SELECT precio_medicamentos.*, medicamentos.med_Nombre
FROM precio_medicamentos
join medicamentos on precio_medicamentos.medicamento_id=medicamentos.id
;


select atencion_medicamentos.*, medicamentos.med_Nombre, atencion_diagnosticos.atencion_id,
pacientes.ape_paterno, pacientes.ape_materno, pacientes.primer_nombre
from atencion_medicamentos
INNER JOIN medicamentos ON atencion_medicamentos.medicamento_id=medicamentos.id
INNER JOIN atencion_diagnosticos on atencion_medicamentos.atencion_diagnostico_id=atencion_diagnosticos.id
INNER JOIN atencions on atencion_diagnosticos.atencion_id=atencions.id
INNER JOIN pacientes on atencions.paciente_id=pacientes.id
limit 50
;


select * from procedimientos where PRCD_V_CODPRO_MINSA = 91001;

select * from atencion_medicamentos
INNER join precio_medicamentos on atencion_medicamentos.medicamento_id=precio_medicamentos.id
INNER JOIN atencion_diagnosticos on atencion_medicamentos.atencion_diagnostico_id=atencion_diagnosticos.id
where atencion_diagnosticos.codigo=967270
;


select sum(atencion_medicamentos.cantidad_entregada*ifnull(precio_medicamentos.PREOPE,0)) as subtotal from atencion_medicamentos
left join precio_medicamentos on atencion_medicamentos.medicamento_id=precio_medicamentos.medicamento_id and precio_medicamentos.CPERIODO='202202'
where atencion_diagnostico_id=100;


SELECT SUM(atencion_medicamentos.cantidad_entregada * COALESCE(precio_medicamentos.PREOPE, 0)) AS subtotal
FROM atencion_medicamentos
LEFT JOIN precio_medicamentos ON atencion_medicamentos.medicamento_id = precio_medicamentos.medicamento_id
                              AND precio_medicamentos.CPERIODO = '202202'
WHERE atencion_diagnostico_id = 505;






SELECT atencion_medicamentos.cantidad_entregada, precio_medicamentos.PREOPE, atencion_medicamentos.cantidad_entregada * COALESCE(precio_medicamentos.PREOPE, 0) AS subtotal
FROM atencion_medicamentos
LEFT JOIN precio_medicamentos ON atencion_medicamentos.medicamento_id = precio_medicamentos.medicamento_id
                              AND precio_medicamentos.CPERIODO = '202202'
WHERE atencion_diagnostico_id = 505;


SELECT atencion_medicamentos.cantidad_entregada, precio_medicamentos.PREOPE, atencion_medicamentos.cantidad_entregada * COALESCE(precio_medicamentos.PREOPE, 0) AS subtotal
FROM atencion_medicamentos
inner join atencion_diagnosticos on atencion_medicamentos.atencion_diagnostico_id=atencion_diagnosticos.id
LEFT JOIN precio_medicamentos ON atencion_medicamentos.medicamento_id = precio_medicamentos.medicamento_id
                              AND precio_medicamentos.CPERIODO = '202202'
WHERE atencion_id = 230;


SELECT sum(coalesce(atencion_medicamentos.cantidad_entregada,0) * COALESCE(precio_medicamentos.PREOPE, 0)) AS subtotal
FROM atencion_medicamentos
inner join atencion_diagnosticos on atencion_medicamentos.atencion_diagnostico_id=atencion_diagnosticos.id
LEFT JOIN precio_medicamentos ON atencion_medicamentos.medicamento_id = precio_medicamentos.medicamento_id
                              AND precio_medicamentos.CPERIODO = '202202'
WHERE atencion_id = 230;

select atencion_medicamentos.* from atencion_medicamentos
where atencion_diagnostico_id=100;


SELECT * from precio_medicamentos;


select atencions.codigo, lote, numero, concat(pacientes.ape_paterno, ' ', pacientes.ape_materno, ' ',pacientes.primer_nombre, ' ',pacientes.segundo_nombre) as paciente,
fecha_atencion, fecha_alta, idusuariotrans,
sum(
case
	when (
		SELECT sum(coalesce(atencion_medicamentos.cantidad_entregada,0) * COALESCE(precio_medicamentos.PREOPE, 0)) AS subtotal
		FROM atencion_medicamentos
		LEFT JOIN precio_medicamentos ON atencion_medicamentos.medicamento_id = precio_medicamentos.medicamento_id
									  AND precio_medicamentos.CPERIODO = periodos.codigo
		WHERE atencion_medicamentos.atencion_diagnostico_id = atencion_diagnosticos.id   
    ) is null
    then
    0
    else(
		SELECT sum(coalesce(atencion_medicamentos.cantidad_entregada,0) * COALESCE(precio_medicamentos.PREOPE, 0)) AS subtotal
			FROM atencion_medicamentos
			LEFT JOIN precio_medicamentos ON atencion_medicamentos.medicamento_id = precio_medicamentos.medicamento_id
										  AND precio_medicamentos.CPERIODO = periodos.codigo
			WHERE atencion_medicamentos.atencion_diagnostico_id = atencion_diagnosticos.id   
    )
end
)
 as medicamentos
from atencions
INNER JOIN pacientes on atencions.paciente_id=pacientes.id
INNER JOIN atencion_diagnosticos on atencions.id=atencion_diagnosticos.atencion_id
LEFT JOIN periodos ON atencions.fecha_atencion BETWEEN periodos.per_FecIniAfi AND periodos.per_FecMaxReg
where year(atencions.fecha_atencion)=2022 and month(atencions.fecha_atencion)=02
group by atencions.id
limit 20
; 


select * from atencions left join periodos on (atencions.fecha_atencion BETWEEN periodos.per_FecIniAfi AND periodos.per_FecMaxReg)
where atencions.codigo = '107623' limit 1;



select medicamentos.med_CodMed as codigo, atencion_medicamentos.cantidad_entregada, medicamentos.med_Nombre,
coalesce((select PREOPE from precio_medicamentos where medicamento_id=91 and CPERIODO = '202202' limit 1),0) as valor
from atencion_medicamentos 
join medicamentos on atencion_medicamentos.medicamento_id=medicamentos.id
join atencion_diagnosticos on atencion_medicamentos.atencion_diagnostico_id=atencion_diagnosticos.id
where atencion_diagnosticos.atencion_id=46
;



SELECT 
  m.med_CodMed AS codigo, 
  am.cantidad_entregada, 
  m.med_Nombre,
  COALESCE(
    (SELECT PREOPE FROM precio_medicamentos pm WHERE am.medicamento_id = pm.medicamento_id AND CPERIODO = FORMAT(atencions.fecha_atencion, 'YYYYMM') LIMIT 1),
    0
  ) AS valor
FROM 
  atencion_medicamentos am
  JOIN medicamentos m ON am.medicamento_id = m.id
  JOIN atencion_diagnosticos ad ON am.atencion_diagnostico_id = ad.id
  JOIN atencions on atencion_diagnosticos.atencion_id=atencions.id
WHERE 
  ad.atencion_id = 46;



select * from medicamentos where med_CodMed = '00091';

select PREOPE from precio_medicamentos where medicamento_id=91 and CPERIODO = '202202';


            SELECT 
            m.med_CodMed AS codigo, 
            am.cantidad_entregada, 
            m.med_Nombre,
            COALESCE(
            (SELECT PREOPE FROM precio_medicamentos pm WHERE am.medicamento_id = pm.medicamento_id AND CPERIODO = FORMAT(atencions.fecha_atencion, 'YYYYMM') LIMIT 1),
            0
            ) AS valor
            FROM 
                atencion_medicamentos am
                JOIN medicamentos m ON am.medicamento_id = m.id
                JOIN atencion_diagnosticos ad ON am.atencion_diagnostico_id = ad.id
                JOIN atencions ON ad.atencion_id = atencions.id
            WHERE 
            ad.atencion_id = 46 ;


560313;






            SELECT 
            i.ins_CodIns AS codigo, 
            ai.cantidad_entregada, 
            i.ins_Nombre,
            COALESCE(
            (SELECT PREOPE FROM precio_insumos pi WHERE ai.insumo_id = pi.insumo_id AND CPERIODO = FORMAT(atencions.fecha_atencion, 'YYYYMM') LIMIT 1),
            0
            ) AS valor
            FROM 
                atencion_procedimientos ai
                JOIN insumos i ON ai.insumo_id = i.id
                JOIN atencion_diagnosticos ad ON ai.atencion_diagnostico_id = ad.id
                JOIN atencions ON ad.atencion_id = atencions.id
            WHERE 
            ad.atencion_id = 46 ;
