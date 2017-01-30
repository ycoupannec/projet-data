<?php

function request($key){
	 
	if(isset($_REQUEST[$key])){
		return $_REQUEST[$key];
	}else{
		return false;
	}

}


