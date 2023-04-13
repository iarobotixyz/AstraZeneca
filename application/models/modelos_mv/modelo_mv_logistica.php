<?php
class Modelo_mv_logistica extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	





   public function listaidlog($cuentaId){//para generar el id del grupo
		$perfil = $this->session->userdata('perfil');
		$this->db->where('cuentaID', $cuentaId);
		$this->db->select('cuentaID,logisticaID');
		$this->db->from('logistica');
		if($perfil === '1'){
			$this->db->where('cuentaID', $cuentaId);
		}
		$pregunta = $this->db->get();
		if($pregunta->num_rows() > 0){
			return $pregunta->result_array();
		}else{
		 	return 0;
		}
	} 

    public function conductname($cuentaId,$logisticaID){
		$this->db->select('cuentaID, logisticaID,nombreContactoCliente');
		$this->db->from('logistica');
        $this->db->where('cuentaID', $cuentaId);
        $this->db->where('logisticaID', $logisticaID);
		$pregunta = $this->db->get();
		
		if($pregunta->num_rows()==1){
			return $pregunta->row_array();
		}else{
            return 0;
        }
	}

	   public function conSelec($cuentaId)//es para imprimir la lista de geozona para asignar a cada vehiculo, se llama en adminVehiculoEditar
	   {
			$perfil = $this->session->userdata('perfil');
			$this->db->select('cuentaID,logisticaID,nombreContactoCliente');
			$this->db->from('logistica');
			if($perfil === '1'){
				$this->db->where('cuentaID', $cuentaId);
			}
			$pregunta = $this->db->get();
			if($pregunta->num_rows() > 0){
				return $pregunta->result_array();
			}else{
			 	return 0;
			}
		} 


	public function datos_usuarios($cuentaId){//listapersonalID-22, 23 generador
		$this->db->select('nombreMostrar, logisticaID, nombreContactoCliente, correoCliente,esActivo,ultimaFechaActualizacion,fechadeCreacion,localizable,Estado,direccionCliente,latitud,longitud,latTranscurso,lonTranscurso,descripcion,FechaLiquida,numeroVisita,tipoVisita,folioEmpresaID,contrasenaRastreo,archivo,folioCorporativoID,personalID,generador,idContactoCliente');
		$this->db->from('logistica');
        $this->db->where('cuentaID', $cuentaId);
		$pregunta = $this->db->get();
		if($pregunta->num_rows() > 0){
			return $pregunta->result_array();	
		}else{
            return 0;
        }
	}
  
    public function disp_activoUSRcon($cuentaId,$tipoEquipo,$esActiva)
	   {//trae los usuarios y conductores para asignar ordenes
			$perfil = $this->session->userdata('perfil');
		
			$this->db->select('cuentaID,dispositivoID,mostrarNombre');
			$this->db->from('dispositivos');
			if($perfil === '1'){
				$this->db->where('cuentaID', $cuentaId);
				$this->db->where('tipoEquipo', $tipoEquipo);
				$this->db->where('esActiva', $esActiva);
			}
			$pregunta = $this->db->get();
			if($pregunta->num_rows() > 0){
				return $pregunta->result_array();
			}else{
			 	return 0;
			}
		} 

    public function disp_activoUSRCcon($cuentaID,$esActiva)
	   {//trae los usuarios y conductores para asignar ordenes
			$perfil = $this->session->userdata('perfil');
		
			$this->db->select('cuentaID,id,nombreCuest');
			$this->db->from('Clientes');
			if($perfil === '1'){
				$this->db->where('cuentaID', $cuentaID);
				$this->db->where('activo', $esActiva);
			}
			$pregunta = $this->db->get();
			if($pregunta->num_rows() > 0){
				return $pregunta->result_array();
			}else{
			 	return 0;
			}
		} 

	public function gen_USRcon($cuentaId,$esActiva)
	   {//trae los usuarios y conductores para asignar ordenes
			$perfil = $this->session->userdata('perfil');
		
			$this->db->select('cuentaID,id,nombreCuest');
			$this->db->from('CCuestionario');
			if($perfil === '1'){
				$this->db->where('cuentaID', $cuentaId);
				$this->db->where('activo', $esActiva);
			}
			$pregunta = $this->db->get();
			if($pregunta->num_rows() > 0){
				return $pregunta->result_array();
			}else{
			 	return 0;
			}
		} 
			public function gen_cuest($cuentaId,$esActiva,$genID)
{//para mostrar los datos en editar
		$this->db->select('p1,p2,p3,p4,p5,p6,p7,p8,p9,p10');
		$this->db->from('CCuestionario');
        $this->db->where('cuentaID', $cuentaId);
        $this->db->where('activo', $esActiva);
        $this->db->where('id', $genID);
        
		$pregunta = $this->db->get();
		
		if($pregunta->num_rows()==1){
			return $pregunta->row_array();
		}else{
            return 0;
        }
	}

				public function nom_cuest($cuentaId,$esActiva,$genID)
{//para mostrar los datos en editar
		$this->db->select('nombreCuest');
		$this->db->from('CCuestionario');
        $this->db->where('cuentaID', $cuentaId);
        $this->db->where('activo', $esActiva);
        $this->db->where('id', $genID);
        
		$pregunta = $this->db->get();
		
		if($pregunta->num_rows()==1){
			return $pregunta->row_array();
		}else{
            return 0;
        }
	}

					public function nom_Personal($cuentaId,$esActiva,$ID)
{//para mostrar los datos en editar
		$this->db->select('mostrarNombre');
		$this->db->from('dispositivos');
        $this->db->where('cuentaID', $cuentaId);
        $this->db->where('esActiva', $esActiva);
        $this->db->where('dispositivoID', $ID);
        
		$pregunta = $this->db->get();
		
		if($pregunta->num_rows()==1){
			return $pregunta->row_array();
		}else{
            return 0;
        }
	}

				public function nom_PCersonal($cuentaId,$esActiva,$ID)
{//para mostrar los datos en editar
		$this->db->select('nombreCuest');
		$this->db->from('Clientes');
        $this->db->where('cuentaID', $cuentaId);
        $this->db->where('activo', $esActiva);
        $this->db->where('id', $ID);
        
		$pregunta = $this->db->get();
		
		if($pregunta->num_rows()==1){
			return $pregunta->row_array();
		}else{
            return 0;
        }
	}

    public function datos_cuentaSelec($cuentaId,$usuarioID){//para mostrar los datos en editar
		$this->db->select('cuentaID,nombreMostrar, logisticaID, esActivo, localizable, imagenvisita, descripcion, contrasenaRastreo, nombreContactoCliente,telefonoCliente,correoCliente,notas,personalID,FechaLiquida,tipoVisita,numeroVisita,folioEmpresaID,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p1b,p2b,p3b,p4b,p5b,p6b,p7b,p8b,p9b,p10b,p1c,p2c,p3c,p4c,p5c,p6c,p7c,p8c,p9c,p10c,direccionCliente,folioCorporativoID,p1nota,p2nota,p3nota,p4nota,p5nota,p6nota,p7nota,p8nota,p9nota,p10nota,generador,idContactoCliente');
		$this->db->from('logistica');
        $this->db->where('cuentaID', $cuentaId);
        $this->db->where('nombreMostrar', $usuarioID);
		$pregunta = $this->db->get();
		
		if($pregunta->num_rows()==1){
			return $pregunta->row_array();
		}else{
            return 0;
        }
	}

    public function insertar_usuario($cuentaID,$usuarioID,$logisticaID){
        $this->load->helper('date');
        $this->db->from('logistica');
		$this->db->where('cuentaID',$cuentaID);
        $this->db->where('nombreMostrar',$usuarioID);
		
        $timestanp = now();
        $timezone = 'UM6';
        $nowF=gmt_to_local($timestanp,$timezone,FALSE);
        $datestring= "%y-%m-%d %h:%i:%s";
        $now = mdate($datestring, $nowF);

///////////Ejemplo
 		//$grupoID=ltrim($nombreMostrar, "ndle");
        //$grupoID=ltrim($nombreMostrar, "\x00..\x1F");//quitamos caracteres raros para asignar al grupoid
         $vowels = array(" ", "-", "_", ".", "<", ">", "(", ")", "?", "!", "'", "¿");
        $nombreMostrar = str_replace($vowels, "", $usuarioID);

		
		$existe = $this->db->count_all_results();
		if($existe==0)
			{
            	$datos_usuario = array();
            		$datos_usuario['cuentaID']=$cuentaID;
            		$datos_usuario['nombreMostrar']=$nombreMostrar;
            		//$datos_usuario['tipoCuenta']=2;
             		$datos_usuario['fechadeCreacion'] = $now;
        			//$datos_usuario['nombreContacto'] =$usuarioID;//
        			$datos_usuario['logisticaID']=$logisticaID;
        			$datos_usuario['esActivo'] = '0';
        			//$datos_usuario['contrasena'] = '';
        			//$datos_usuario['notificarCorreo'] = '';
        			//$datos_usuario['telefonoContacto'] ='';
        			//$datos_usuario['correoContacto'] ='';
        			$datos_usuario['tipoCuenta'] = '2';
					$this->db->insert('logistica', $datos_usuario);
            	return 1;
			}
		else 
		{
			return 0;
		}
    }




     public function update_archivo($cuantaID,$logisticaID,$datos_dispositivo)
     {
     	$Estado='3';//para editar los datos despues desde algo visible para el admin ,
        $this->db->from('logistica');
		$this->db->where('cuentaID',$cuantaID);
        $this->db->where('Estado',$Estado);//tambien para evitar hackeos en intentar archivar un id que no es
        $this->db->where('logisticaID',$logisticaID);
		$this->db->update('logistica', $datos_dispositivo); 
    }











     public function update_usuarios($cuantaID,$usuarioID,$datos_usuario)//actualiza los datos edicion de usuarios
     { //se utiliza tambien en maneja_cuentas
        $this->db->from('logistica');
		$this->db->where('cuentaID',$cuantaID);
        $this->db->where('logisticaID',$usuarioID);
		$this->db->update('logistica', $datos_usuario); 
		
     }
     public function update_usuarios_dispo($cuantaID,$usuarioID,$datos)//actualiza los datos de usuario en tabla dispositivos
     { //se utiliza tambien en maneja_cuentas
        $this->db->from('dispositivos');
		$this->db->where('cuentaID',$cuantaID);
        $this->db->where('dispositivoID',$usuarioID);
		$this->db->update('dispositivos', $datos); 
     }


     public function update_cuenta_usuarios($cuantaID,$datos_usuario){//para cuando se deesactiva una cuenta se desactiva todos los usuarios maneja_cuentas
        $this->db->from('logistica');//aun no se utiliza pero es pensado para eso
		$this->db->where('cuentaID',$cuantaID);
		
		$this->db->update('logistica', $datos_usuario); 
		
    }
	
    public function borrar_usuarios($cuentaId,$usuarioID){
		$this->db->where('cuentaID', $cuentaId);
		$this->db->where('nombreMostrar', $usuarioID);
		$this->db->delete('logistica'); 
	}


    public function borrar_logistica($cuentaId,$id)
    {
		$this->db->where('cuentaID', $cuentaId);
		$this->db->where('logisticaID', $id);
		$this->db->delete('logistica'); 
	}
	public function borrar_cuenta_usuarios($cuentaId){//Para cuando se quiere borrar o desactivar toda una cuenta relacionado con maneja_cuentas
		$this->db->where('cuentaID', $cuentaId);
		$this->db->delete('logistica'); 
	}
}