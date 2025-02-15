obtener usuarios de cpanel
SELECT usuario.*, rol.nombre as rol, agencia.nombre as agencia FROM `usuario` 
left join rolusuario on usuario.codusuario=rolusuario.idusuario join rol on rolusuario.idrol=rol.id
left join agencia_usuario on usuario.codusuario=agencia_usuario.idusuario join agencia on agencia_usuario.idagencia=agencia.idagencia;



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

SELECT ubicacion.*, distrito.nombre as distrito, provincia.nombre as provincia FROM `ubicacion` join distrito on ubicacion.distrito=distrito.iddistrito join provincia on distrito.idprovincia = provincia.idprovincia;



obtener solicitudes
SELECT solicitud.*, agencia.nombre as agencia FROM `solicitud` join agencia on solicitud.idagencia=agencia.idagencia