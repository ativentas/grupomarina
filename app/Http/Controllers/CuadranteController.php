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
use View;


class CuadranteController extends Controller
{	
	public function index()
	{
		//los cuadrantes de hoy y los pendientes
		$cuadrantes = Cuadrante::whereDate('fecha', '=', date('Y-m-d'))->orwhere('estado', 'Pendiente')->orderBy('fecha','ASC')->get();
		return view('controlHorario.gestionCuadrantes',compact('cuadrantes'));		
	}

	public function generarCuadrante(Request $request)
	{
		$this->validate($request, [
			'empresa' => 'required',
			'fecha' => 'required|date',
			]);
		$fecha = date('Y-m-d',strtotime($request->fecha));
		
		$cuadrante = Cuadrante::whereDate('fecha','=', $fecha)->where('empresa', $request->empresa)->first();
		
		//si no existe ya uno hecho, se crea		
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
				$linea->entrada = $empleado->entrada;
				$linea->salida = $empleado->salida;
				if ($empleado->turno_partido == 1){
					$linea->tipo = 'Partido';
					$linea->entrada2 = $empleado->entrada2;
					$linea->salida2 = $empleado->salida2;
				}

				$linea->save();
			}
			$lineas = LineaCuadrante::where('cuadrante_id', $cuadrante->id)->get();
			return redirect()->route('cuadrante.detalle', $cuadrante->id)->with('info', 'ya puedes confeccionar el horario');

		} elseif ($cuadrante->count()){
			$lineas = LineaCuadrante::where('cuadrante_id', $cuadrante->id)->get();
			return view ('controlHorario.detalleCuadrante', compact('cuadrante', 'lineas'))->with('info', 'Ya existe un Cuadrante para ese día!!! Puedes modificarlo o salir para crear otro diferente');
		}
	}

	public function mostrarDetalle($cuadrante_id){
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
		  return $messages;
		}
		
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

		function getHeader($headers, $name) {
		  	foreach($headers as $header) {
		    	if($header['name'] == $name) {
		      		return $header['value'];
	    		}
	  		}
		}

		$cuadrante = Cuadrante::where('id', $cuadrante_id)->first();
		$lineas = LineaCuadrante::where('cuadrante_id', $cuadrante_id)->get();
		
		$fecha = $cuadrante->fecha;
		$fecha = date_format($fecha,'d-m-Y');

		if($cuadrante->estado == 'Pendiente') {

			define('APPLICATION_NAME', 'Gmail API PHP Quickstart');
			define('CREDENTIALS_PATH', base_path().'/storage/app/.credentials/gmail-php-quickstart.json');
			define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
			// If modifying these scopes, delete your previously saved credentials
			define('SCOPES', implode(' ', array(
			  Google_Service_Gmail::GMAIL_MODIFY)
			));
			/**
			 * Returns an authorized API client.
			 * @return Google_Client the authorized client object
			 */
			
			// Get the API client and construct the service object.
			$client = getClient();
			$service = new Google_Service_Gmail($client);
			$userId ='me';
			
			//lista de labels con ids
			// $results = $service->users_labels->listUsersLabels($userId);
			// dd($results);
			
			$messages = listMessages($service, $userId, $fecha, null);

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

						$subject = getHeader($headers, 'Subject');

						$linea->asunto = $subject;
						$linea->estado = 'Firmado';
						
						$linea->save();
						modifyMessage($service,$userId,$linea->mensaje_id,$labelsToAdd,$labelsToRemove);

					}else if (count($mensaje) > 1){
						dd('hay mas de un mensaje de '.$email.' para el día '.$fecha.'. ENTRA EN GMAIL, BORRA EL REPETIDO Y VUELVE A REFRESCAR LA PAGINA');
					}else if (!count($mensaje)){
						// dd('no hay ninguno');
					}
				}
			}
		}		
		return view('controlHorario.detalleCuadrante', compact('cuadrante', 'lineas'));
	}

	public function updateCuadrante ($request, $cuadrante_id)
	{		
		//update las lineas
	
		$lineas = LineaCuadrante::where('cuadrante_id', $cuadrante_id)->get();
		foreach ($lineas as $linea) {
			$tipo = 'tipo'.$linea->id;
			$entrada = 'entrada'.$linea->id;
			$salida = 'salida'.$linea->id;
			$entrada2 = 'entrada2'.$linea->id;
			$salida2 = 'salida2'.$linea->id;
			$linea->tipo = $request->$tipo;
			$linea->save();
			
			switch ($linea->tipo) {
				case 'Normal':					
					$this->updateLineaHorarios($linea->id,$request->$entrada,$request->$salida,null,null,false);
					break;
				case 'Partido':
					$this->updateLineaHorarios($linea->id,$request->$entrada,$request->$salida,$request->$entrada2,$request->$salida2,false);
					break;
				case 'Libre':
					$this->updateLineaHorarios($linea->id,null,null,null,null,false);
					break;
				case 'Vacaciones':
					$this->updateLineaHorarios($linea->id,null,null,null,null,false);
					break;				
				case 'Baja':
					$this->updateLineaHorarios($linea->id,null,null,null,null,false);
					break;				
				case 'Falta':
					$this->updateLineaHorarios($linea->id,null,null,null,null,false);
					break;

				
				default:
					# code...
					break;
			}
			
			# code...
		}
		return redirect()->back()->with('info', 'Cambios guardados');
	}
	
	public function updateLineaHorarios($linea_id, $entrada, $salida, $entrada2, $salida2, $requerir){
		$linea= LineaCuadrante::where('id', $linea_id)->first();
		if ($entrada == null) {
			$linea->entrada = null;
		}else {
			$linea->entrada = date("H:i",strtotime($entrada));
		}
		if ($salida == null) {
			$linea->salida = null;
		}else {
			$linea->salida = date("H:i",strtotime($salida));	
		}

		if ($entrada2 == null) {
			$linea->entrada2 = null;
		}else {
			$linea->entrada2 = date("H:i",strtotime($entrada2));
		}
		if ($salida2 == null) {
			$linea->salida2 = null;
		}else {
			$linea->salida2 = date("H:i",strtotime($salida2));	
		}

		$linea->save();
		$fecha = $linea->cuadrante->fecha->format('d/m/Y');
		if($requerir == true){
			
			if ($linea->entrada == null || $linea->salida == null){
				return false;
				//falta hacer esto....no se porque no redirecciona y sigue ejecutando la funcion original (requerirConfirmacion())
			}
			
			$linea->estado = 'Requerido';
			//enviar email
			$to = $linea->email;
			// Text before new line.%0D%0AText after new line.

			if($linea->tipo == 'Partido' && $linea->entrada2 !=null && $linea->salida2 !=null){
				$subject = $fecha.', de '.$linea->entrada.' a '.$linea->salida.', y de '.$linea->entrada2.' a '.$linea->salida2;
			} else {
				$subject = $fecha.', de '.$linea->entrada.' a '.$linea->salida;		
			}
			
			$view = View::make('templates.mail.confirmacionHorario', ['subject' => $subject]);
			$body = $view->render();

			$this->enviarMensaje($to,$subject,$body);
			
			$linea->save();			
		}
	}


	public function requerirConfirmacion(Request $request, $cuadrante_id)
	{		

		$linea_id = $_POST['action'];
		
		if($linea_id == 'actualizarTodos'){
			$this->updateCuadrante($request,$cuadrante_id);
			$cuadrante=Cuadrante::where('id',$cuadrante_id)->first();
			$cuadrante->estado = 'Validado';
			$cuadrante->save();
			return redirect()->back()->with('info', 'Si ya son correctos todos los datos, puedes requerir que confirmen el horario');
		}elseif($linea_id > 0){
		//update la linea $request->linea_id
		//cambiar estado de la linea a Requerido
			$entrada = 'entrada'.$linea_id;
			$salida = 'salida'.$linea_id;
			$entrada2 = 'entrada2'.$linea_id;
			$salida2 = 'salida2'.$linea_id;
			
			$this->updateLineaHorarios($linea_id, $request->$entrada, $request->$salida, $request->$entrada2, $request->$salida2, true);
			//TODO: if updateLineaHorarios false....
			return redirect()->back()->withInput()->with('info', 'confirmación solicitada');
		}else{
			return view('controlHorario.detalleCuadrante', $cuadrante_id)->with('info', 'no se han encontrado registros');
		}
	}

	public function enviarMensaje($to, $subject, $body)
	{
		$mail = new PHPMailer;
		// $mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'costaservishorarios@gmail.com';        // SMTP username
		$mail->Password = '654654901';                           // SMTP password
		$mail->SMTPSecure = 'tls';              // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;
		$mail->isHTML(true);

		$mail->addAddress($to);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->setFrom('costaservishorarios@gmail.com');
		// $mail->addReplyTo('costaservishorarios@gmail.com');

		if(!$mail->send()) {
			echo 'No se pudo enviar el mensaje. ';
			echo 'Error Mailer: ' . $mail->ErrorInfo;
		} 

	}
}