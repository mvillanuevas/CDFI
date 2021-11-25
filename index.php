<?php
require_once '../SWInclude.php';
use src\LoginXmlRequest as loginSAT;
use src\RequestXmlRequest as solicita;
use src\VerifyXmlRequest as verifica;
use src\Utils as util;


$cert = file_get_contents('resources/fes130828my0.cer');
$key = file_get_contents('resources/Claveprivada_FIEL_FES130828MY0_20211118_092622.key');
$rfc = 'FES130828MY0';
$fechaInicial = '2021-10-01T00:00:00';
$fechaFinal = '2021-10-31T12:59:59';
$TipoSolicitud = 'CFDI';
$idSolicitud = '1fb832ff-6a25-4616-8ca8-04478690cc29';
$idPaquete = '1fb832ff-6a25-4616-8ca8-04478690cc29_01';
$ResponseAuth = loginSAT::soapRequest($cert,$key);
var_dump($ResponseAuth);

$ResponseRequest = solicita::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $fechaInicial, $fechaFinal, $TipoSolicitud);
var_dump($ResponseRequest);

$ResponseVerify = verifica::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idSolicitud);
var_dump($ResponseVerify);

$ResponseDownload = descarga::soapRequest($cert, $key, $ResponseAuth->token, $rfc, $idPaquete);
util::saveBase64File($ResponseDownload->Paquete, $idPaquete.".zip");
var_dump($ResponseDownload);

?>
