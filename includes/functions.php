<?php

	function verificar_consulta($consulta)
	{
		if(!$consulta)
		{
			die("No se ha podido realizar la consulta: " . mysql_error());
		}
	}
	
	function validar_campos_obligatorios($campos_obligatorios)
	{
		$errores = array();
		foreach($campos_obligatorios as $campo)
		{			
			if(!isset($_POST[$campo]) || (empty($_POST[$campo]) && !is_numeric($_POST[$campo])))
			{
				$errores[] = $campo;
			}	
		}
		return $errores;
	}
	
	function preparar_consulta($consulta)
	{
		$mq_activado = get_magic_quotes_gpc();
		if(function_exists("mysql_real_escape_string"))
		{
			if($mq_activado)
			{
				$consulta = stripslashes($consulta);
			}
			$consulta = mysql_real_escape_string($consulta);
		}
		else
		{
			if(!$mq_activado)
			{
				$consulta = addslashes($consulta);
			}
		}
		return $consulta;
	}
	
	function obtener_cursos($publico)
	{
		global $conexion;
		$consulta = "SELECT * 
					FROM cursos ";
		if($publico)
		{
			$consulta .= "WHERE visibilidad=1 ";
		}
		$consulta .= "ORDER BY posicion ASC";
	  	$cursos = mysql_query($consulta,$conexion);
		verificar_consulta($cursos);
		return $cursos;
	}
	
	function obtener_capitulos_por_curso($curso_id,$publico)
	{
		global $conexion;
		$consulta = "SELECT * 
					FROM capitulos 
					WHERE curso_id={$curso_id} ";
		if($publico)
		{
			$consulta .= "AND visibilidad=1 ";
		}
		$consulta .= "ORDER BY posicion ASC";
		$capitulos = mysql_query($consulta,$conexion);
		verificar_consulta($capitulos);	
		return $capitulos;
	}
	
	function obtener_curso_por_id($curso_id)
	{
		global $conexion;
		$consulta = "SELECT * FROM cursos WHERE id=" . $curso_id . " LIMIT 1";
		$respuesta = mysql_query($consulta,$conexion);
		verificar_consulta($respuesta);
		if($curso = mysql_fetch_array($respuesta))
		{
			return $curso;
		}
		else
		{
			return NULL;	
		}		
	}
	
	function obtener_capitulo_por_id($capitulo_id)
	{
		global $conexion;
		$consulta = "SELECT * FROM capitulos WHERE id=" . $capitulo_id . " LIMIT 1";
		$respuesta = mysql_query($consulta,$conexion);
		verificar_consulta($respuesta);
		if($capitulo = mysql_fetch_array($respuesta))
		{
			return $capitulo;
		}
		else
		{
			return NULL;	
		}		
	}
	
	function obtener_pagina()
	{
		global $curso_reg;
		global $capitulo_reg;
		
		if(isset($_GET["curso"]))
		{
			$curso_reg = obtener_curso_por_id($_GET["curso"]);			
			$capitulo_reg = obtener_primer_capitulo($_GET["curso"]);
		} 
		elseif(isset($_GET["capitulo"]))
		{
			$capitulo_reg = obtener_capitulo_por_id($_GET["capitulo"]);
			$curso_reg = NULL;
		}
		else
		{
			$capitulo_reg = NULL;
			$curso_reg = NULL;
		}
	}
	
	function obtener_primer_capitulo($curso_id)
	{
		$resultado = obtener_capitulos_por_curso($curso_id,true);
		if($capitulo = mysql_fetch_array($resultado))
		{
			return $capitulo;	
		}
		else
		{
			return NULL;	
		}
	}
	
	function menu_publico($curso_reg,$capitulo_reg)
	{
		$salida = "<ul class=\"cursos\">";	 
		$cursos = obtener_cursos(true);				
		while($curso = mysql_fetch_array($cursos))
		{
			$salida .= "<li";
			if($curso["id"] == $curso_reg["id"])
			{
				$salida .= " class=\"selected\"";
			}				
			$salida .= "><a href=\"index.php?curso=" . urlencode($curso["id"]) ."\">" . $curso["nombre"] . "</a></li>";
			if($curso["id"] == $curso_reg["id"])			
			{
				$salida .= "<ul class='capitulos'>";
				$capitulos = obtener_capitulos_por_curso($curso["id"],true);
				while($capitulo = mysql_fetch_array($capitulos))
				{
					$salida .= "<li";
					if($capitulo["id"] == $capitulo_reg["id"])
					{
						$salida .= " class=\"selected\"";
					}	
					$salida .= "><a href=\"index.php?capitulo=" . urlencode($capitulo["id"]) . "\">" . $capitulo["nombre"] . "</a></li>";
				}
				$salida .= "</ul>";
			}			
		}  
  		$salida .= "</ul>";
		return $salida;
	}
	
	function menu($curso_reg,$capitulo_reg)
	{
		$salida = "<ul class=\"cursos\">";	 
		$cursos = obtener_cursos(false);				
		while($curso = mysql_fetch_array($cursos))
		{
			$salida .= "<li";
			if($curso["id"] == $curso_reg["id"])
			{
				$salida .= " class=\"selected\"";
			}				
			$salida .= "><a href=\"edit_course.php?curso=" . urlencode($curso["id"]) ."\">" . $curso["nombre"] . "</a></li><ul class='capitulos'>";
							
			$capitulos = obtener_capitulos_por_curso($curso["id"],false);
			
			while($capitulo = mysql_fetch_array($capitulos))
			{
				$salida .= "<li";
				if($capitulo["id"] == $capitulo_reg["id"])
				{
					$salida .= " class=\"selected\"";
				}	
				$salida .= "><a href=\"content.php?capitulo=" . urlencode($capitulo["id"]) . "\">" . $capitulo["nombre"] . "</a></li>";
			}
			$salida .= "</ul>";
		}  
  		$salida .= "</ul>";
		return $salida;
	}
?>