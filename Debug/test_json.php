<?php 

$str_origin = '{
  "rootRecordatorios": {
    "recordatorio": [
      {
        "marca": "Carmel",
        "zona": "001",
        "fecha_entrega_pedido": "20160805",
        "fecha_facturacion_pedido": "20160805",
        "fecha_limite_ingreso_pedido": "20160805",
        "fecha_cambios_devoluciones": "20160805",
        "lugar_hora_cambios": "GRAN HOTEL. CALLE 54 # 45-92     9:00 am A 12:00 pm",
        "fecha_limite_pago_pedido": "20160805",
        "fecha_conferencia": "20160805",
        "lugar_hora_conferencia": "GRAN HOTEL. CALLE 54 # 45-92     03:00:00 p. m."
      },
      {
        "marca": "Pacifika",
        "zona": "3121",
        "fecha_entrega_pedido": "20160805",
        "fecha_facturacion_pedido": "20160805",
        "fecha_limite_ingreso_pedido": "20160805",
        "fecha_cambios_devoluciones": "20160805",
        "lugar_hora_cambios": "SEDE CALDAS CAMBIOS 9:00 am A 12:00 pm",
        "fecha_limite_pago_pedido": "20160805",
        "fecha_conferencia": "20160805",
        "lugar_hora_conferencia": "SEDE CALDAS 03:00:00 p. m."
      },
      {
        "marca": "Loguin",
        "zona": "11008",
        "fecha_entrega_pedido": "20160805",
        "fecha_facturacion_pedido": "20160805",
        "fecha_limite_ingreso_pedido": "20160805",
        "fecha_cambios_devoluciones": "20160805",
        "lugar_hora_cambios": "HOTEL POBLADO 9:00 am A 12:00 pm",
        "fecha_limite_pago_pedido": "20160805",
        "fecha_conferencia": "20160805",
        "lugar_hora_conferencia": "HOTEL POBLADO 03:00:00 p. m."
      }
    ]
  }
}';


$str_new = '{
  "rootRecordatorios": {
    "recordatorio": {
		"1":{
			"001":{
		        "fecha_entrega_pedido": "20160805",
		        "fecha_facturacion_pedido": "20160805",
		        "fecha_limite_ingreso_pedido": "20160805",
		        "fecha_cambios_devoluciones": "20160805",
		        "lugar_hora_cambios": "GRAN HOTEL. CALLE 54 # 45-92     9:00 am A 12:00 pm",
		        "fecha_limite_pago_pedido": "20160805",
		        "fecha_conferencia": "20160805",
		        "lugar_hora_conferencia": "GRAN HOTEL. CALLE 54 # 45-92     03:00:00 p. m."
			}
		},
		"2":{
			"3121":{
		        "fecha_entrega_pedido": "20160805",
		        "fecha_facturacion_pedido": "20160805",
		        "fecha_limite_ingreso_pedido": "20160805",
		        "fecha_cambios_devoluciones": "20160805",
		        "lugar_hora_cambios": "SEDE CALDAS CAMBIOS 9:00 am A 12:00 pm",
		        "fecha_limite_pago_pedido": "20160805",
		        "fecha_conferencia": "20160805",
		        "lugar_hora_conferencia": "SEDE CALDAS 03:00:00 p. m."
			}
		},
		"3":{
			"11008":{
		        "fecha_entrega_pedido": "20160805",
		        "fecha_facturacion_pedido": "20160805",
		        "fecha_limite_ingreso_pedido": "20160805",
		        "fecha_cambios_devoluciones": "20160805",
		        "lugar_hora_cambios": "HOTEL POBLADO 9:00 am A 12:00 pm",
		        "fecha_limite_pago_pedido": "20160805",
		        "fecha_conferencia": "20160805",
		        "lugar_hora_conferencia": "HOTEL POBLADO 03:00:00 p. m."
			}
		}
    }
  }
}';


$asesora_new = '{
	"rootAsesoras": {
		"asesora": [
		{
			"nro_documento": "1000061554",
			"tipo_documento": "CC",
			"marca": "1",
			"zona": "0134",
			"saldo_pagar": "617969",
			"cupo_valor_factura": "700000",
			"cupo_valor_catalogo": "800000",
			"numero_ultima_factura": "6507681",
			"valor_ultima_factura": "480000",
			"campana_ultima_factura": "201608",
			"fecha_vencimiento_factura": "20160915",
			"fecha_factura": "20160801",
			"numero_doc_ultima_nc": "7836776",
			"valor_ultima_nc": "165700",
			"fecha_ultima_nc": "20160720",
			"tipo_ultima_nc": "FS",
			"numero_ultima_remision": "4587523",
			"numero_doc_ultimo_pago": "6507681",
			"valor_ultimo_pago": "201500",
			"fecha_ultimo_pago": "20160805",
			"fecha_entrega_pedido": "20160805",
			"fecha_facturacion_pedido": "20160805",
			"fecha_limite_ingreso_pedido": "20160805",
			"fecha_cambios_devoluciones": "20160805",
			"lugar_hora_cambios": "SEDE CALDAS CAMBIOS",
			"fecha_limite_pago_pedido": "20160805",
			"fecha_conferencia": "20160805",
			"lugar_hora_conferencia": "SEDE CALDAS",
			"nombre_directora_zona": "DORIS ROCIO ALVAREZ GUTIERREZ",
			"telefono_directora_zona": "5102356",
			"email_directora_zona": "DORISROCIOAL@GMAIL.COM",
			"campana_actual": "201608",
			"puntos_campana_actual": "945",
			"campana_anterior": "201607",
			"puntos_campana_anterior": "800",
			"campana_trasanterior": "201606",
			"puntos_campana_trasanterior": "650",
			"estado": "Pedido",
			"numero_creditos": "50",
			"clasificado_por_valor": "AA41",
			"division": "DIVISION 04",
			"primer_nombre": "ANGIE",
			"segundo_nombre": "LORENA",
			"primer_apellido": "DIAZ",
			"segundo_apellido": "GOMEZ",
			"fecha_nacimiento": "19941103",
			"persona_referencio": "39719181",
			"departamento": "11",
			"ciudad": "11001",
			"direccion": "CR 5M 48 S 40",
			"barrio": "MARRUECOS",
			"telefono1": "4931254",
			"telefono2": "4931254",
			"telefono3": "4931254",
			"celular": "3107736882",
			"email": "LORE.2203@HOTMAIL.COM"
		}, 
		{
			"nro_documento": "43555666",
			"tipo_documento": "CC",
			"marca": "1",
			"zona": "0525",
			"saldo_pagar": "617969",
			"cupo_valor_factura": "700000",
			"cupo_valor_catalogo": "800000",
			"numero_ultima_factura": "6507681",
			"valor_ultima_factura": "480000",
			"campana_ultima_factura": "201608",
			"fecha_vencimiento_factura": "20160915",
			"fecha_factura": "20160801",
			"numero_doc_ultima_nc": "7836776",
			"valor_ultima_nc": "165700",
			"fecha_ultima_nc": "20160720",
			"tipo_ultima_nc": "FS",
			"numero_ultima_remision": "4587523",
			"numero_doc_ultimo_pago": "6507681",
			"valor_ultimo_pago": "201500",
			"fecha_ultimo_pago": "20160805",
			"fecha_entrega_pedido": "20160805",
			"fecha_facturacion_pedido": "20160805",
			"fecha_limite_ingreso_pedido": "20160805",
			"fecha_cambios_devoluciones": "20160805",
			"lugar_hora_cambios": "SEDE CALDAS CAMBIOS",
			"fecha_limite_pago_pedido": "20160805",
			"fecha_conferencia": "20160805",
			"lugar_hora_conferencia": "SEDE CALDAS",
			"nombre_directora_zona": "PEPITA MENDIETA",
			"telefono_directora_zona": "5102356",
			"email_directora_zona": "PEPITAMENDIETA@GMAIL.COM",
			"campana_actual": "201608",
			"puntos_campana_actual": "945",
			"campana_anterior": "201607",
			"puntos_campana_anterior": "800",
			"campana_trasanterior": "201606",
			"puntos_campana_trasanterior": "650",
			"estado": "Pedido",
			"numero_creditos": "50",
			"clasificado_por_valor": "AA41",
			"division": "DIVISION 04",
			"primer_nombre": "KYRA",
			"segundo_nombre": "MARIA",
			"primer_apellido": "ORTIZ",
			"segundo_apellido": "CASAS",
			"fecha_nacimiento": "19941103",
			"persona_referencio": "39719181",
			"departamento": "11",
			"ciudad": "11001",
			"direccion": "CR 5M 48 S 40",
			"barrio": "MARRUECOS",
			"telefono1": "4931254",
			"telefono2": "4931254",
			"telefono3": "4931254",
			"celular": "3107736882",
			"email": "KYRA.ORTIZ@HOTMAIL.COM"
		}
	]
	}
}';



try {
	echo "<pre>";
	print_r(json_decode($asesora_new));
	
} catch (Exception $e) {
	echo "<pre>";
	print_r(json_decode($e));
	
}




?>