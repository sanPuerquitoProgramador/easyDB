<?php 
function ConsultaTabla($tabla, $campo, $condicion=NULL, $operadorIncluido = NULL, $ordenado=NULL, $debug = NULL)
{
	$igualOrNot = ($operadorIncluido!=NULL) ? '' : ' = ';
	$campoConsulta='';
	$condicionConsulta='';
	foreach($campo as $item) {$campoConsulta.= $item.',';}
	if($condicion!=NULL) {
		$condicionConsulta = 'WHERE ';
		foreach($condicion as $key => $value){$condicionConsulta.=$key.$igualOrNot.$value.' AND ';}
		$condicionConsulta = trim($condicionConsulta,' AND ');
	}
	$campoConsulta = trim($campoConsulta,',');
	$qr = sprintf("SELECT %s FROM %s %s %s",
	$campoConsulta, $tabla, $condicionConsulta,$ordenado);
	if($debug!=NULL){
		echo $qr;
		return(NULL);
	}
	$e=EjecutaQuery($qr);
	$row_qr=mysqli_fetch_assoc($e);
	$r['totalItems']=mysqli_num_rows($e);
	$r['debug'] = $qr;
	do{
		$r['items'][]=$row_qr;
	}while($row_qr = mysqli_fetch_assoc($e));
	return($r);
	
}
function ActualizaTabla($tabla, $campoValor, $condicionValor, $debug = NULL){
	$newValues = '';
	$condicion = '';
	
	foreach($campoValor as $key => $valor) {$newValues.= $key.' = '.$valor.',';}	
	foreach($condicionValor as $keyC => $valorC){$condicion.= $keyC.' = '.$valorC.' AND ';}
	
	$newValues = trim($newValues,','); 
	$condicion = trim($condicion,' AND ');
	
	$qr = sprintf("UPDATE %s SET %s WHERE %s",
		$tabla, $newValues, $condicion);
		
	if($debug!=NULL){
		echo $qr;
		return(NULL);
	}
	$r = EjecutaQuery($qr);
	return($r);
}
function InsertaTabla($tabla, $campoValor, $debug = NULL){
	$campo = '(';
	$valor = '(';
	foreach($campoValor as $keyCampo => $itemValor){
			$campo.=$keyCampo.',';
			$valor.=$itemValor.',';
	}
	$campo = trim($campo,',');
	$valor = trim($valor,',');
	$campo.=')';
	$valor.=')';
	$qr = 'INSERT INTO '.$tabla.' '.$campo.' VALUES '.$valor;
	
	if($debug!=NULL){
		echo $qr;
		return(NULL);
	}
	$r = EjecutaQuery($qr,'InsertaGenernal',1);
	return($r);
}
function BorraTabla($tabla, $condicionValor, $debug = NULL){
	$newValues = '';
	$condicion = '';

	foreach($condicionValor as $keyC => $valorC){$condicion.= $keyC.' = '.$valorC.' AND ';}
	
	$condicion = trim($condicion,' AND ');
	
	$qr = sprintf("DELETE FROM %s WHERE %s",
		$tabla, $condicion);
		
	if($debug!=NULL){
		echo $qr;
		return(NULL);
	}
	$r = EjecutaQuery($qr);
	return($r);
}

//EJECUCION GLOBAL
function EjecutaQuery($qr,$mError='',$insert = NULL){	
	$easy_db_host = $GLOBALS['easy_db_host'];
	$easy_db_db = $GLOBALS['easy_db_db'];
	$easy_db_name = $GLOBALS['easy_db_name'];
	$easy_db_pwd = $GLOBALS['easy_db_pwd'];
	$touch = mysqli_connect($easy_db_host, $easy_db_name, $easy_db_pwd) or die(mysql_error());
	mysqli_select_db($touch,$easy_db_db);
	mysqli_query($touch,"SET NAMES 'utf8'");
	$e = mysqli_query($touch,$qr) or trigger_error(mysqli_error($touch).'['.$mError.']');
	if(!(is_null($insert))){ $e=array('e'=>$e,'id'=>mysqli_insert_id($touch)); }
	return($e);
}
?>