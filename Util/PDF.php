<?php
 date_default_timezone_set('America/Argentina/Buenos_Aires'); // Establecer la zona horaria predeterminada

class PDF extends FPDF {

    // Crea Formulario de comprobante de autos
    public function generarComprobante($persona, $autos) {
        $this->AddPage();  // Agregar una página al PDF
        $this->agregarEncabezado();
        $this->agregarDatosPersona($persona);
        $this->agregarDatosEmpresa();
        $this->agregarSeccionAutos();
        $this->agregarTablaAutos($autos);
        $this->agregarMensajeFinal();
        return $this->mostrarPDF();
    }

    // Encabezado del PDF
    private function agregarEncabezado() {
        $this->SetTitle('Comprobante Autos Persona'); //  el título del PDF
        $this->SetFont('Arial', 'B', 16); //  la fuente, el estilo y el tamaño de la fuente
        $this->SetTextColor(32, 100, 210); //  el color del texto (RGB) 
        $this->Cell(150, 10, "Certificado Autos Persona", 0, 0, 'L'); // ancho, alta, texto, borde, salto de línea, alineación
        $this->Ln(9); // Salto de línea en milimetros
        $this->Image('../../img/auto.jpg', 120, 12, 70, 70, 'jpg'); //nombre, posicion horizontal, vertical, ancho, altura, tipo.
    }

    // Datos de la persona
    private function agregarDatosPersona($persona) {
        if ($persona) { 
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(39, 39, 51);
            $this->Cell(150, 9, 'Nombre: ' . $persona["nombre"], 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(150, 9, 'Apellido: ' . $persona["apellido"], 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(150, 9, 'DNI: ' . $persona["nroDni"], 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(150, 9, 'Fecha de nacimiento: ' . $persona["fechaNac"], 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(150, 9, iconv("UTF-8", "ISO-8859-1", 'Teléfono: ' . $persona["telefono"]), 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(150, 9, 'Domicilio: ' . $persona["domicilio"], 0, 0, 'L');
            $this->Ln(10);
        } else {
            // Handle case where persona is null
            $this->Cell(150, 9, 'No se encontraron datos de la persona.', 0, 0, 'L');
        }
    }


    // Datos de la empresa
    private function agregarDatosEmpresa() {
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 7, iconv("UTF-8", "ISO-8859-1", "Fecha de emisión:"), 0, 0);
        $this->SetTextColor(97, 97, 97);
        $this->Cell(116, 7, iconv("UTF-8", "ISO-8859-1", date("d/m/Y H:i A")), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(39, 39, 51);
        $this->Ln(7);
        $this->SetTextColor(39, 39, 51);
        $this->Cell(6, 7, iconv("UTF-8", "ISO-8859-1", "Dirección:"), 0, 0);
        $this->Ln(5);
        $this->SetTextColor(97, 97, 97);
        $this->Cell(109, 7, iconv("UTF-8", "ISO-8859-1", "Neuquén Capital, Neuquén, Argentina"), 0, 0);
        $this->Ln(9);
    }

    // Sección de autos asociados
    private function agregarSeccionAutos() {
        $this->SetFont('Arial', 'B', 15);
        $this->SetTextColor(32, 100, 210);
        $this->Cell(0, 10, "Autos Asociados", 0, 1, 'C'); // Centrado
        $this->Ln(5);
    }

    // Tabla de autos
    private function agregarTablaAutos($autos) {
        $this->SetFont('Arial', '', 12);
        $this->SetFillColor(23, 83, 201); // 
        $this->SetDrawColor(23, 83, 201); //
        $this->SetTextColor(255, 255, 255);

        $this->Cell(80, 10, "Patente", 1, 0, 'C', true);
        $this->Cell(60, 10, "Marca", 1, 0, 'C', true);
        $this->Cell(40, 10, "Modelo", 1, 0, 'C', true);
        $this->Ln(8);

        $this->SetTextColor(39, 39, 51);
        if (!empty($autos)) {
            foreach ($autos as $auto) {
                $this->Cell(80, 10, $auto["patente"], 1, 0, 'C');
                $this->Cell(60, 10, $auto["marca"], 1, 0, 'C');
                $this->Cell(40, 10, $auto["modelo"], 1, 0, 'C');
                $this->Ln(10);
            }
        } else {
            $this->SetFont('Arial', 'I', 12);
            $this->SetTextColor(255, 0, 0);
            $this->Cell(0, 10, 'No hay autos asociados a esta persona.', 0, 1, 'C');
        }
    }

    // Mensaje final
    private function agregarMensajeFinal() {
        $this->Ln(10);
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(97, 97, 97);
        $this->Cell(0, 10, 'Este documento es un comprobante generado automaticamente.', 0, 1, 'C');
        $this->Cell(0, 10, 'pagina '.$this->PageNo(), 0, 0, 'C');
    }


    private function mostrarPDF() {
        // Enviar el archivo PDF al navegador (Inline)
        $this->Output('I', 'doc.pdf'); // 'I' muestra el PDF en el navegador con el nombre correcto
    }
    
    

   /////////////////////////////////////////////////////////////////Crea un registro de la compra seleccionada//////////////////////////////////
   public function generarPdfCliente($arrayFinal) {
    // Agregar una página al PDF
    $this->AddPage('landscape');
    
    // Añadir contenido al PDF
    $this->agregarEncabezadoRegistro();
    $this->agregarDatosCompra($arrayFinal);
    $this->agregarDatosEmpresaRegistro();
    $this->agregarMensajeFinal();

    // Definir la ruta donde se guardará el archivo PDF
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Tienda/pdfs/'; // Cambia esta ruta si es necesario
    $fileName = 'CompraEstado_' . uniqid() . '.pdf'; // Nombre único para evitar colisiones
    $filePath = $uploadDir . $fileName;
    $publicUrl = '/Tienda/pdfs/' . $fileName; // URL pública accesible desde el navegador

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
    private function agregarEncabezadoRegistro() {
        $this->SetTitle('Mi compra'); // Establecer el título del PDF
        $this->SetFont('Times', 'B', 30); // Establece la fuente, el estilo y el tamaño de la fuente
        $this->SetTextColor(32, 100, 210); // Establecer el color del texto (RGB)
        $this->Cell(150, 10, strtoupper("Registro de Compra"), 0, 0, 'L'); // Agregar un texto a la celda
        $this->Ln(9); // Salto de línea
        //$this->Image('../../img/personaLogo.png', 220, 3, 70, 30, 'png'); // Agregar una imagen al PDF
        }

    // Datos de la empresa en el registro
    private function agregarDatosEmpresaRegistro() {
        $this->Ln(15);
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
        $this->Ln(9);
    }
//Crea la planilla de la compra.
    private function agregarDatosCompra($arrayFinal) {
        $this->Ln(8);
        $this->SetFont('Times', 'B', 12);
        $this->SetFillColor(23, 83, 201);
        $this->SetDrawColor(23, 83, 201);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(30, 10, "ID Compraa Estado", 1, 0, 'C', true);
        $this->Cell(45, 10, "ID Compra", 1, 0, 'C', true);
        $this->Cell(40, 10, "ID Compra Estado Tipo", 1, 0, 'C', true);
        $this->Cell(30, 10, "Estado", 1, 0, 'C', true);
        $this->Cell(37, 10, "Fecha de Inicio ", 1, 0, 'C', true);
        $this->Cell(30, 10, "Fecha de Fin", 1, 0, 'C', true);
        $this->Cell(30, 10, "Comprador", 1, 0, 'C', true);
        $this->Ln(0.2);
        //Datos de la compra
        if($arrayFinal["idcompraestadotipo"] = 1){
            $estado = "Iniciada";
        }
        elseif($arrayFinal["idcompraestadotipo"] = 2) {
            $estado = "Aceptada";
        }
        elseif($arrayFinal["idcompraestadotipo"] = 3) {
            $estado = "Enviada";
        }
        elseif($arrayFinal["idcompraestadotipo"] = 4) {
            $estado = "Cancelada";
        }
        $this->Ln(10);
        $this->SetFont('Times', '', 12);
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(172, 216, 230);
        $this->Cell(30, 10, $arrayFinal["idcompraestado"], 1, 0, 'C', true);
        $this->Cell(45, 10, $arrayFinal["idcompra"], 1, 0, 'C');
        $this->Cell(40, 10, $arrayFinal["idcompraestadotipo"], 1, 0, 'C');
        $this->Cell(37, 10, $estado, 1, 0, 'C');
        $this->Cell(37, 10, $arrayFinal["cefechaini"], 1, 0, 'C');
        $this->Cell(30, 10, $arrayFinal["cefechafin"], 1, 0, 'C');
        $this->Cell(30, 10, "...", 1, 0, 'C');
    }
}

