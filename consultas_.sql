obtener usuarios de cpanel
SELECT usuario.*, 
       rol.nombre AS rol, 
       agencia.nombre AS agencia 
FROM usuario
LEFT JOIN rolusuario ON usuario.codusuario = rolusuario.idusuario 
LEFT JOIN rol ON rolusuario.idrol = rol.id
LEFT JOIN agencia_usuario ON usuario.codusuario = agencia_usuario.idusuario 
LEFT JOIN agencia ON agencia_usuario.idagencia = agencia.idagencia;




JJARA02
obtener clientes : 
SELECT codcliente, dni, idasesor, dniaval, estado, date(fechareg) as fecha_reg, time(fechareg) as hora_reg, agencia.nombre as agencia FROM `cliente`
join agencia on cliente.idagencia=agencia.idagencia;


obtener personas
SELECT persona.*, distrito.nombre as distrito, provincia.nombre as provincia FROM `persona` join distrito on persona.distrito_nac=distrito.iddistrito join provincia on distrito.idprovincia=provincia.idprovincia


obtener ubicaciones
select id,tipo,tipovia,nombrevia,nro,interior,mz,lote,tipozona,nombrezona,referencia,distrito.nombre as distrito,provincia.nombre as provincia from ubicacion
join distrito on ubicacion.distrito=distrito.iddistrito
join provincia on distrito.idprovincia = provincia.idprovincia

SELECT ubicacion.*, distrito.nombre as distrito, provincia.nombre as provincia FROM `ubicacion` 
join distrito on ubicacion.distrito=distrito.iddistrito 
join provincia on distrito.idprovincia = provincia.idprovincia;



obtener solicitudes
SELECT solicitud.*, agencia.nombre as agencia FROM `solicitud` join agencia on solicitud.idagencia=agencia.idagencia


analisis
balance
perdidas
propuesta


es de la misma tabla