obtener usuarios de cpanel
SELECT usuario.*, rol.nombre as rol FROM `usuario` join rolusuario on usuario.codusuario=rolusuario.idusuario join rol on rolusuario.idrol=rol.id;



obtener clientes : 
SELECT codcliente, dni, idasesor, dniaval, estado, date(fechareg) as fecha_reg, time(fechareg) as hora_reg, agencia.nombre as agencia FROM `cliente`
join agencia on cliente.idagencia=agencia.idagencia;


obtener personas
SELECT persona.*, distrito.nombre as distrito, provincia.nombre as provincia FROM `persona` join distrito on persona.distrito_nac=distrito.iddistrito join provincia on distrito.idprovincia=provincia.idprovincia