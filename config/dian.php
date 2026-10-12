<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Facturación Electrónica DIAN (Colombia)
    |--------------------------------------------------------------------------
    | Configuración para generar y firmar el XML UBL 2.1 que se envía a la DIAN.
    | Los valores se leen desde el archivo .env.
    */

    // '1' = Producción, '2' = Habilitación (pruebas)
    'environment' => env('DIAN_ENVIRONMENT', '2'),

    // Moneda del documento
    'currency' => env('DIAN_CURRENCY', 'COP'),

    // Ruta absoluta del certificado .p12 y su contraseña
    'certificate_path' => env('DIAN_CERTIFICATE_PATH'),
    'certificate_password' => env('DIAN_CERTIFICATE_PASSWORD'),

    // Tipo de documento del emisor: '31' = NIT
    'supplier_identification_type' => env('DIAN_SUPPLIER_ID_TYPE', '31'),
    // NIT del emisor y dígito de verificación (calculado automáticamente si está vacío)
    'supplier_nit' => env('DIAN_SUPPLIER_NIT'),
    'supplier_dv' => env('DIAN_SUPPLIER_DV'),
    'supplier_name' => env('DIAN_SUPPLIER_NAME'),
    'supplier_regime' => env('DIAN_SUPPLIER_REGIME', 'O-13'), // Responsable de IVA
    'supplier_email' => env('DIAN_SUPPLIER_EMAIL'),
    'supplier_phone' => env('DIAN_SUPPLIER_PHONE'),
    'supplier_address' => env('DIAN_SUPPLIER_ADDRESS'),
    // Código DANE del municipio (ej. 11001 Bogotá, 05001 Medellín)
    'supplier_city_code' => env('DIAN_SUPPLIER_CITY_CODE', '11001'),
    'supplier_city_name' => env('DIAN_SUPPLIER_CITY_NAME', 'Bogotá DC'),
    'supplier_state_name' => env('DIAN_SUPPLIER_STATE_NAME', 'Distrito Capital'),
    'supplier_state_code' => env('DIAN_SUPPLIER_STATE_CODE', '11'),
    // '1' = Persona jurídica, '2' = Persona natural
    'supplier_person_type' => env('DIAN_SUPPLIER_PERSON_TYPE', '1'),

    // Datos por defecto del adquiriente
    'customer_id_type' => env('DIAN_CUSTOMER_ID_TYPE', '13'),
    'customer_regime' => env('DIAN_CUSTOMER_REGIME', 'R-99-PN'),
    'customer_city_code' => env('DIAN_CUSTOMER_CITY_CODE', '11001'),
    'customer_city_name' => env('DIAN_CUSTOMER_CITY_NAME', 'Bogotá DC'),
    'customer_state_name' => env('DIAN_CUSTOMER_STATE_NAME', 'Distrito Capital'),
    'customer_state_code' => env('DIAN_CUSTOMER_STATE_CODE', '11'),
    // Adquiriente por defecto cuando no hay NIT (consumidor final)
    'final_consumer_nit' => env('DIAN_FINAL_CONSUMER_NIT', '222222222222'),
    'final_consumer_name' => env('DIAN_FINAL_CONSUMER_NAME', 'Consumidor Final'),

    // Resolución de numeración autorizada por la DIAN
    'resolution_number' => env('DIAN_RESOLUTION_NUMBER'),
    'resolution_prefix' => env('DIAN_RESOLUTION_PREFIX'),
    'resolution_from' => env('DIAN_RESOLUTION_FROM'),
    'resolution_to' => env('DIAN_RESOLUTION_TO'),
    'resolution_start_date' => env('DIAN_RESOLUTION_START_DATE'),
    'resolution_end_date' => env('DIAN_RESOLUTION_END_DATE'),

    // Datos del software registrado en la DIAN
    'software_id' => env('DIAN_SOFTWARE_ID'),
    'software_pin' => env('DIAN_SOFTWARE_PIN'),
    // NIT del proveedor del software (el facturador si es software propio)
    'software_provider_nit' => env('DIAN_SOFTWARE_PROVIDER_NIT'),
    // Clave técnica entregada por la DIAN (necesaria para el CUFE)
    'technical_key' => env('DIAN_TECHNICAL_KEY'),

    // Código de la unidad de medida por defecto (DIAN / UN/ECE)
    // 94 = Unidad, NIU = Unidad de artículo
    'unit_code' => env('DIAN_UNIT_CODE', '94'),

    // Impuesto por defecto cuando el producto no tiene uno asignado.
    // 01 = IVA, 04 = INC, 03 = ICA
    'default_tax_code' => env('DIAN_DEFAULT_TAX_CODE', '01'),
    'default_tax_name' => env('DIAN_DEFAULT_TAX_NAME', 'IVA'),
    'default_tax_percent' => env('DIAN_DEFAULT_TAX_PERCENT', '0.00'),

    // Prefijo del archivo XML descargado
    'file_prefix' => env('DIAN_FILE_PREFIX', 'factura'),
];
