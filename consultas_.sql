/*USUARIOS*/

SELECT usuario.*, 
       rol.nombre AS rol, 
       agencia.nombre AS agencia 
FROM usuario
LEFT JOIN rolusuario ON usuario.codusuario = rolusuario.idusuario 
LEFT JOIN rol ON rolusuario.idrol = rol.id
LEFT JOIN agencia_usuario ON usuario.codusuario = agencia_usuario.idusuario 
LEFT JOIN agencia ON agencia_usuario.idagencia = agencia.idagencia;



obtener ubicaciones
SELECT id,tipo,tipovia,nombrevia,nro,interior,mz,lote,tipozona,nombrezona,referencia,distrito.nombre AS distrito,provincia.nombre AS provincia FROM ubicacion
JOIN distrito ON ubicacion.distrito=distrito.iddistrito
JOIN provincia ON distrito.idprovincia = provincia.idprovincia

SELECT ubicacion.*, distrito.nombre AS distrito, provincia.nombre AS provincia FROM `ubicacion` 
JOIN distrito ON ubicacion.distrito=distrito.iddistrito 
JOIN provincia ON distrito.idprovincia = provincia.idprovincia;

obtener personas
SELECT persona.*, distrito.nombre AS distrito, provincia.nombre AS provincia FROM `persona` JOIN distrito ON persona.distrito_nac=distrito.iddistrito JOIN provincia ON distrito.idprovincia=provincia.idprovincia



JJARA02
obtener clientes : 
SELECT codcliente, dni, idasesor, dniaval, estado, DATE(fechareg) AS fecha_reg, TIME(fechareg) AS hora_reg, agencia.nombre AS agencia FROM `cliente`
JOIN agencia ON cliente.idagencia=agencia.idagencia;





obtener solicitudes
SELECT solicitud.*, agencia.nombre AS agencia FROM `solicitud` JOIN agencia ON solicitud.idagencia=agencia.idagencia


SELECT * FROM analisis_cual;
SELECT * FROM balance;
SELECT * FROM det_balance;
SELECT * FROM perdidasyganancias;
SELECT * FROM propuestacred;
SELECT * FROM desembolso;
SELECT * FROM detcalendariopagos;
SELECT * FROM kardex;
SELECT * FROM creditosacancelar;
SELECT * FROM segurodesgravamen;
SELECT * FROM pago;
SELECT * FROM pagomora;
SELECT * FROM junta;








es de la misma tablaS