<?php
 date_default_timezone_set('America/Argentina/Buenos_Aires'); // Establecer la zona horaria predeterminada

class PDF extends FPDF {
/////////////////////////////////////////Crea un registro de la compra seleccionada//////////////////////////////////
    
public function generarPdfCliente($arrayFinal){
    // Agregar una página al PDF
    $this->AddPage('landscape');
    
    // Añadir contenido al PDF
    $this->agregarEncabezadoCompra();
    $this->agregarDatosCliente($arrayFinal);
    $this->agregarDatosCompra($arrayFinal);
    $this->agregarTablaItems($arrayFinal);
    $this->agregarDatosEmpresaCompra();
    $this->agregarMensajeFinal();

    // Definir la ruta donde se guardará el archivo PDF
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Tienda/vista/pdfs/'; // Cambia esta ruta si es necesario
    $fileName = 'CompraEstado_' . uniqid() . '.pdf'; // Nombre único para evitar colisiones
    $filePath = $uploadDir . $fileName;
    $publicUrl = '/Tienda/vista/pdfs/' . $fileName; // URL pública accesible desde el navegador

    // Crear el directorio si no existe
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Crear el directorio con permisos de escritura
    }

    // Guardar el PDF en el servidor
    $this->Output($filePath, 'F'); // 'F' guarda el archivo en el servidor

    // Verificar si el archivo se generó correctamente
    if (file_exists($filePath)) {
        // Devolver la URL pública
        return [
            'success' => true,
            'url' => $publicUrl
        ];
    } else {
        // Devolver un mensaje de error
        return [
            'success' => false,
            'message' => 'Error al guardar el PDF en el servidor.'
        ];
    }
}

//Crea el encabezado del registro
    private function agregarEncabezadoCompra() {
        $this->SetTitle('Mi compra'); // Establecer el título del PDF
        $this->SetFont('Times', 'B', 30); // Establece la fuente, el estilo y el tamaño de la fuente
        $this->SetTextColor(32, 100, 210); // Establecer el color del texto (RGB)
        $this->Cell(150, 10, strtoupper("Registro de Compra"), 0, 0, 'L'); // Agregar un texto a la celda
        $this->Ln(9); // Salto de línea
        //$this->Image('../../img/personaLogo.png', 220, 3, 70, 30, 'png'); // Agregar una imagen al PDF
        }

    // Datos de la empresa en el registro
    private function agregarDatosEmpresaCompra() {
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(30, 7, iconv("UTF-8", "ISO-8859-1", "Fecha de emisión:"), 0, 0);
        $this->SetTextColor(97, 97, 97);
        $this->Ln(5);
        $this->Cell(116, 7, iconv("UTF-8", "ISO-8859-1", date("d/m/Y H:i A")), 0, 0, 'L');
        $this->SetFont('Times', 'B', 12);
        $this->SetTextColor(39, 39, 51);
        $this->Ln(7);
        $this->SetTextColor(39, 39, 51);
        $this->Cell(6, 7, iconv("UTF-8", "ISO-8859-1", "Dirección:"), 0, 0);
        $this->Ln(5);
        $this->SetTextColor(97, 97, 97);
        $this->Cell(109, 7, iconv("UTF-8", "ISO-8859-1", "Neuquén Capital, Neuquén, Argentina"), 0, 0);
    }

private function agregarDatosCliente($arrayFinal) {
    $this->Ln(8);
    // Accede al objeto Usuario desde el array
    $cliente = $arrayFinal[0];  // El índice 0 contiene el objeto Usuario
    $idUsuario = $cliente->getIdUsuario();  
    $nombre = $cliente->getUsNombre(); 
    $email = $cliente->getUsMail();        
    if ($cliente) { 
        $this->SetFont('Times', 'B', 14);
        $this->SetTextColor(39, 39, 51);
        $this->Cell(0, 10, "Datos del comprador", 0, 0, 'L');
        $this->Ln(5);
        $this->SetFont('Times', '', 12);
        $this->SetTextColor(39, 39, 51);
        $this->Cell(150, 9, 'ID: ' . $idUsuario, 0, 0, 'L');
        $this->Ln(5);
        $this->Cell(150, 9, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Nombre: ' . $nombre), 0, 0, 'L');
        $this->Ln(5);
        $this->Cell(150, 9, 'Email: ' . $email, 0, 0, 'L');
        $this->Ln(10);
    } else {
        $this->Cell(0, 10, "No se encontraron datos de la ", 0, 0, 'L');
    }
}

//Crea la planilla de la compra.
    private function agregarDatosCompra($arrayFinal) {
        $this->SetFont('Times', 'B', 14);
        $this->SetTextColor(39, 39, 51);
        $this->Cell(0, 10, "Datos de la compra", 0, 0, 'L');
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->SetFillColor(23, 83, 201);
        $this->SetDrawColor(23, 83, 201);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(50, 10, "ID Compra Estado", 1, 0, 'C', true);
        $this->Cell(45, 10, "ID Compra", 1, 0, 'C', true);
        $this->Cell(60, 10, "ID Compra Estado Tipo", 1, 0, 'C', true);
        $this->Cell(40, 10, "Estado", 1, 0, 'C', true);
        $this->Cell(40, 10, "Fecha de Inicio ", 1, 0, 'C', true);
        $this->Cell(40, 10, "Fecha de Fin", 1, 0, 'C', true);
        $this->Ln(0.2);
        //Datos de la compra
        if($arrayFinal["idcompraestadotipo"] == 1){
            $estado = "Iniciada";
        }
        elseif($arrayFinal["idcompraestadotipo"] == 2) {
            $estado = "Aceptada";
        }
        elseif($arrayFinal["idcompraestadotipo"] == 3) {
            $estado = "Enviada";
        }
        elseif($arrayFinal["idcompraestadotipo"] == 4) {
            $estado = "Cancelada";
        }
        $fechaFin = (is_null($arrayFinal["cefechafin"]) || $arrayFinal["cefechafin"] === "null") ? "-" : $arrayFinal["cefechafin"];
        $this->Ln(10);
        $this->SetFont('Times', '', 12);
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(172, 216, 230);
        $this->Cell(50, 10, $arrayFinal["idcompraestado"], 1, 0, 'C', true);
        $this->Cell(45, 10, $arrayFinal["idcompra"], 1, 0, 'C');
        $this->Cell(60, 10, $arrayFinal["idcompraestadotipo"], 1, 0, 'C');
        $this->Cell(40, 10, $estado, 1, 0, 'C');
        $this->Cell(40, 10, $arrayFinal["cefechaini"], 1, 0, 'C');
        $this->Cell(40, 10, $fechaFin, 1, 0, 'C');
    }

    // Tabla de items de la compra.
    private function agregarTablaItems($items) {
        $this->Ln(15);
        $this->SetFont('Times', 'B', 14);
        $this->SetTextColor(39, 39, 51);
        $this->Cell(0, 10, "Items de la compra", 0, 0, 'L');
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->SetFillColor(23, 83, 201);
        $this->SetDrawColor(23, 83, 201);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(35, 10, "ID Producto", 1, 0, 'C', true);
        $this->Cell(60, 10, "Nombre Producto", 1, 0, 'C', true);
        $this->Cell(100, 10, "Detalle Producto", 1, 0, 'C', true);
        $this->Cell(40, 10, "Cantidad", 1, 0, 'C', true);
        $this->Cell(40, 10, "Precio Producto", 1, 0, 'C', true);
        $this->Ln(10);
        $this->SetFont('Times', '', 12);
        $this->SetTextColor(0, 0, 0);
        // Obtengo el array de objetos de la compra
        $itemsCompra = $items[1];
        // Recorrer los items de la compra (productos)
        foreach ($itemsCompra as $compraItem) {
            // Acceder al producto dentro del item
            $producto = $compraItem->getObjProducto();
            $this->Cell(35, 10, $producto->getIdProducto(), 1, 0, 'C');
            $this->Cell(60, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $producto->getPronombre()), 1, 0, 'C');
            $this->Cell(100, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $producto->getProdetalle()), 1, 0, 'C');
            $this->Cell(40, 10, $compraItem->getCicantidad(), 1, 0, 'C');
            $this->Cell(40, 10, $producto->getProimporte(), 1, 0, 'C');
            $this->Ln(10);
        }
    }    

    // Mensaje final
    private function agregarMensajeFinal() {
        $this->Ln(8);
        $this->SetFont('Times', 'I', 10);
        $this->SetTextColor(97, 97, 97);
        $this->Cell(0, 10, 'Este documento es un comprobante generado automaticamente.', 0, 1, 'C');
        $this->Cell(0, 10, 'pagina '.$this->PageNo(), 0, 0, 'C');
    }
}