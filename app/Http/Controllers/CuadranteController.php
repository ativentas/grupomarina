<?php

namespace Pedidos\Http\Controllers;

use PDF;
use Auth;
use Pedidos\Models\User;
use Pedidos\Models\Cuadrante;
use Pedidos\Models\LineaCuadrante;
use Illuminate\Http\Request;
use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;
use Google_Client;
use PHPMailer;



class CuadranteController extends Controller
{	
	public function index()
	{
		//los cuadrantes de hoy y los pendientes
		$cuadrantes = Cuadrante::whereDate('fecha', '=', date('Y-m-d'))->orwhere('estado', 'Pendiente')->orderBy('fecha','ASC')->get();
		// return view('controlHorario.gestionCuadrantes',compact('cuadrantes'));

		define('APPLICATION_NAME', 'Gmail API PHP Quickstart');
		define('CREDENTIALS_PATH', __DIR__ . '/.credentials/gmail-php-quickstart.json');
		define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
		// If modifying these scopes, delete your previously saved credentials
		// at ~/.credentials/gmail-php-quickstart.json
		define('SCOPES', implode(' ', array(
		  Google_Service_Gmail::GMAIL_MODIFY)
		));
		/**
		 * Returns an authorized API client.
		 * @return Google_Client the authorized client object
		 */
		function getClient() {
		  $client = new Google_Client();
		  $client->setApplicationName(APPLICATION_NAME);
		  $client->setScopes(SCOPES);
		  $client->setAuthConfigFile(CLIENT_SECRET_PATH);
		  $client->setAccessType('offline');
		  $client->setApprovalPrompt('force');//esta linea la he añadido yo

		  // Load previously authorized credentials from a file.
		  $credentialsPath = CREDENTIALS_PATH;
		  // dd($credentialsPath);
		  if (file_exists($credentialsPath)) {
		   
		    $accessToken = file_get_contents($credentialsPath);
		   
		  } else {
		    // Request authorization from the user.
		    dd('no hay autorización, habrá que modificar el código');
		    $authUrl = $client->createAuthUrl();
		    printf("Open the following link in your browser:\n%s\n", $authUrl);
		    print 'Enter verification code: ';
		    $authCode = trim(fgets(STDIN));

		    // Exchange authorization code for an access token.
		    $accessToken = $client->authenticate($authCode);

		    // Store the credentials to disk.
		    if(!file_exists(dirname($credentialsPath))) {
		      mkdir(dirname($credentialsPath), 0700, true);
		    }
		    file_put_contents($credentialsPath, $accessToken);
		    // printf("Credentials saved to %s\n", $credentialsPath);
		  }
		  
		  $client->setAccessToken($accessToken);
			
		  // Refresh the token if it's expired.
		  if ($client->isAccessTokenExpired()) {
		    // $prueba=$client->getRefreshToken();
		    // dd($prueba);
		    $client->refreshToken($client->getRefreshToken());
		    
		    file_put_contents($credentialsPath, $client->getAccessToken());
		  }
		  return $client;
		}
		// Get the API client and construct the service object.
		$client = getClient();
		$service = new Google_Service_Gmail($client);

		$userId ='me';

		function listMessages($service, $userId) {
		  $pageToken = NULL;
		  $messages = array();
		  $opt_param = array();
		  $opt_param['q'] = 'subject:'.date('d-m-y');//solo los mensajes de hoy

		  do {
		    try {
		      if ($pageToken) {
		        $opt_param['pageToken'] = $pageToken;
		      }
		      $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
		      if ($messagesResponse->getMessages()) {
		        $messages = array_merge($messages, $messagesResponse->getMessages());
		        $pageToken = $messagesResponse->getNextPageToken();
		      }
		    } catch (Exception $e) {
		      print 'An error occurred: ' . $e->getMessage();
		    }
		  } while ($pageToken);
			
		  return $messages;

		}
		$messages = listMessages($service, $userId);
		// dd($messages);
		
		return view('controlHorario.gestionCuadrantes',compact('cuadrantes','messages'));		
	}


	public function generarCuadrante(Request $request)
	{
		
		$fecha = date('Y-m-d',strtotime($request->fecha));
		
		$cuadrante = Cuadrante::whereDate('fecha','=', $fecha)->where('empresa', $request->empresa)->first();
		
		//si existe uno ya hecho, se muestra el detalle
		// dd($repetido->id);
		
		if (!$cuadrante){
			$cuadrante = new Cuadrante;
			$cuadrante->fecha = $fecha;
			$cuadrante->empresa = $request->empresa;
			$cuadrante->estado = 'Pendiente';
			$cuadrante->save();
			
			$empleados = User::where('empresa', $request->empresa)->get();
			
			foreach ($empleados as $empleado) {
				$linea = new LineaCuadrante;
				$linea->cuadrante_id = $cuadrante->id;
				$linea->empleado_id = $empleado->id;
				$linea->email = $empleado->email;
				$linea->horaEntradaM = $empleado->entrada;
				$linea->horaSalidaM = $empleado->salida;
				$linea->save();

			}
			$lineas = LineaCuadrante::where('cuadrante_id', $cuadrante->id)->get();
			return redirect()->route('cuadrante.detalle', $cuadrante->id);
			// return view ('controlHorario.detalleCuadrante', compact('cuadrante','lineas'))->with('info', 'ya puedes confeccionar el horario');
		}elseif($cuadrante->count()){
			$lineas = LineaCuadrante::where('cuadrante_id', $cuadrante->id)->get();
			return view ('controlHorario.detalleCuadrante', compact('cuadrante', 'lineas'))->with('info', 'Ya existe un Cuadrante para ese día!!! Puedes modificarlo o salir para crear otro diferente');
		}



	}

	public function mostrarDetalle($cuadrante_id){
		$cuadrante = Cuadrante::where('id', $cuadrante_id)->first();
		$lineas = LineaCuadrante::where('cuadrante_id', $cuadrante_id)->get();
		
		$fecha = $cuadrante->fecha;
		$fecha = date_format($fecha,'d-m-Y');

		//google API
		//mensajes de ese día
		define('APPLICATION_NAME', 'Gmail API PHP Quickstart');
		define('CREDENTIALS_PATH', __DIR__ . '/.credentials/gmail-php-quickstart.json');
		define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
		// If modifying these scopes, delete your previously saved credentials
		// at ~/.credentials/gmail-php-quickstart.json
		define('SCOPES', implode(' ', array(
		  Google_Service_Gmail::GMAIL_MODIFY)
		));
		/**
		 * Returns an authorized API client.
		 * @return Google_Client the authorized client object
		 */
		function getClient() {
		  $client = new Google_Client();
		  $client->setApplicationName(APPLICATION_NAME);
		  $client->setScopes(SCOPES);
		  $client->setAuthConfigFile(CLIENT_SECRET_PATH);
		  $client->setAccessType('offline');
		  $client->setApprovalPrompt('force');//esta linea la he añadido yo

		  // Load previously authorized credentials from a file.
		  $credentialsPath = CREDENTIALS_PATH;
		  // dd($credentialsPath);
		  if (file_exists($credentialsPath)) {
		   
		    $accessToken = file_get_contents($credentialsPath);
		   
		  } else {
		    // Request authorization from the user.
		    dd('no hay autorización, habrá que modificar el código');
		    $authUrl = $client->createAuthUrl();
		    printf("Open the following link in your browser:\n%s\n", $authUrl);
		    print 'Enter verification code: ';
		    $authCode = trim(fgets(STDIN));

		    // Exchange authorization code for an access token.
		    $accessToken = $client->authenticate($authCode);

		    // Store the credentials to disk.
		    if(!file_exists(dirname($credentialsPath))) {
		      mkdir(dirname($credentialsPath), 0700, true);
		    }
		    file_put_contents($credentialsPath, $accessToken);
		    // printf("Credentials saved to %s\n", $credentialsPath);
		  }
		  
		  $client->setAccessToken($accessToken);
			
		  // Refresh the token if it's expired.
		  if ($client->isAccessTokenExpired()) {
		    $client->refreshToken($client->getRefreshToken());	    
		    file_put_contents($credentialsPath, $client->getAccessToken());
		  }
		  return $client;
		}
		// Get the API client and construct the service object.
		$client = getClient();
		$service = new Google_Service_Gmail($client);
		$userId ='me';
		
		//lista de labels con ids
		// $results = $service->users_labels->listUsersLabels($userId);
		// dd($results);


		function listMessages($service, $userId, $fecha, $email) {
		  $pageToken = NULL;
		  $messages = array();
		  $opt_param = array();		  
		  //mensaje de ese empleado para ese día
		  $opt_param['q'] = 'subject:'.$fecha.' from:'.$email.' label:Inbox';
		 
		  do {
		    try {
		      if ($pageToken) {
		        $opt_param['pageToken'] = $pageToken;
		      }
		      $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
		      if ($messagesResponse->getMessages()) {
		        $messages = array_merge($messages, $messagesResponse->getMessages());
		        $pageToken = $messagesResponse->getNextPageToken();
		      }
		    } catch (Exception $e) {
		      print 'An error occurred: ' . $e->getMessage();
		    }
		  } while ($pageToken);
			// dd($messages);		
		  return $messages;

		}
		// $messages = listMessages($service, $userId, $fecha);
		// dd($messages);
		
		function modifyMessage($service, $userId, $messageId, $labelsToAdd, $labelsToRemove) {
		  $mods = new Google_Service_Gmail_ModifyMessageRequest();
		  $mods->setAddLabelIds($labelsToAdd);
		  $mods->setRemoveLabelIds($labelsToRemove);
		  try {
		    $message = $service->users_messages->modify($userId, $messageId, $mods);
		    // print 'Message with ID: ' . $messageId . ' successfully modified.';
		    return $message;
		  } catch (Exception $e) {
		    print 'An error occurred: ' . $e->getMessage();
		  }
		}

		$messages = listMessages($service, $userId, $fecha, null);
		
		function getHeader($headers, $name) {
		  	foreach($headers as $header) {
		    	if($header['name'] == $name) {
		      		return $header['value'];
	    		}
	  		}
		}

		if($messages){
			foreach ($lineas as $linea) {
				$email = $linea->empleado->email;
				$mensaje = listMessages($service,$userId,$fecha,$email);		

				$labelsToAdd = ['Label_1'];
				$labelsToRemove= ['INBOX'];
				// dd(count($mensaje));
				if (count($mensaje)==1){
					$linea->mensaje_id = $mensaje[0]->id;
					$detalle_mensaje = $service->users_messages->get($userId,$mensaje[0]->id);
					$headers= $detalle_mensaje->getPayload()->getHeaders();
					
					// function getHeader($headers, $name) {
					//   	foreach($headers as $header) {
					//     	if($header['name'] == $name) {
					//       		return $header['value'];
				 //    		}
				 //  		}
					// }

					$subject = getHeader($headers, 'Subject');

					$linea->asunto = $subject;
					
					$linea->save();
					modifyMessage($service,$userId,$linea->mensaje_id,$labelsToAdd,$labelsToRemove);

				}else if (count($mensaje) > 1){
					dd('hay mas de un mensaje de '.$email.' para el día '.$fecha.'. BORRA EL MAS ANTIGUO Y VUELVE A INTENTARLO');
				}else if (!count($mensaje)){
					// dd('no hay ninguno');
				}
			}
		}		
		return view('controlHorario.detalleCuadrante', compact('cuadrante', 'lineas'));
	}




	public function updateCuadrante (Request $request, $cuadrante_id)
	{		
		//update las lineas
		return redirect()->back()->with('info', 'Cambios guardados');
	}
	
	public function updateLineaHorarios($linea_id, $entrada, $salida, $requerir){
		$linea= LineaCuadrante::where('id', $linea_id)->first();
		if ($entrada == null) {
			$linea->horaEntradaM = null;
		}else {
			$linea->horaEntradaM = date("G:i",strtotime($entrada));
		}
		if ($salida == null) {
			$linea->horaSalidaM = null;
		}else {
			$linea->horaSalidaM = date("G:i",strtotime($salida));	
		}
		$linea->save();
		$fecha = $linea->cuadrante->fecha->format('d/m/Y');
		if($requerir == true){
			$linea->estado = 'Requerido';
			//enviar email
			$this->enviarMensaje($linea->email,$fecha.', de '.$linea->horaEntradaM.' a '.$linea->horaSalidaM,'Responde al mensaje si estás conforme con el horario que pone en el asunto');
			$linea->save();			
		}
	}
	
	public function requerirConfirmacion(Request $request, $cuadrante_id)
	{		

		$linea_id = $_POST['requerir'];
		
		if($linea_id == 0){
			$lineas = LineaCuadrante::where('cuadrante_id', $cuadrante_id)->get();
			//update horarios de todas las lineas
			return redirect()->back()->with('info', 'ya están todas las confirmaciones de horario requeridas');
		}elseif($linea_id > 0){
		//update la linea $request->linea_id
		//cambiar estado de la linea a Requerido
			$entrada = $request->entrada;
			$salida = $request->salida;
			$this->updateLineaHorarios($linea_id, $entrada, $salida, true);
			return redirect()->back()->withInput()->with('info', 'confirmación solicitada');
		}else{
			return view('controlHorario.detalleCuadrante', $cuadrante_id)->with('info', 'no se han encontrado registros');
		}
	}

	public function enviarMensaje($to, $subject, $body)
	{
		// dd($to,$subject,$body);
		$mail = new PHPMailer;
		// $mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'costaservishorarios@gmail.com';                 // SMTP username
		$mail->Password = '654654901';                           // SMTP password
		$mail->SMTPSecure = 'tls';                // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;
		$mail->isHTML(true);

		//si uso las clases, habrá que hacer esto de manera diferente
		$mail->setFrom('costaservishorarios@gmail.com');
		$mail->addAddress($to);
		$mail->addReplyTo('costaservishorarios@gmail.com');
		$mail->Subject = $subject;
		$mail->Body = $body;
		if(!$mail->send()) {
			echo 'No se pudo enviar el mensaje. ';
			echo 'Error Mailer: ' . $mail->ErrorInfo;
		} else {
			// echo 'Mensaje enviado';			
		}

		//esto es para usar las clases de Codecourse, pero de momento no me aclaro...
		// $mail = new Mailer($mail);
		// $mail->send(function($m){.
		// 	$m->to($to);
		// 	$m->subject($subject);
		// });
	}
}