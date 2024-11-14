<footer class="bg-primary text-white py-3 mt-auto">
    <div class="container d-flex flex-column align-items-center">
        <!-- Sección sobre nosotros y GitHub con separador -->
        <div class="d-flex align-items-center mb-3">
        <a href="<?php echo BASE_URL . '/Vista/Paginas/nosotros.php'; ?>" class="text-white text-decoration-none mx-2">Sobre Nosotros</a>

            <span class="text-white mx-2">|</span>
            <a href="https://github.com/ailenFlores/tienda" class="text-white text-decoration-none mx-2">GitHub</a>
            <span class="text-white mx-2">|</span>
            <a href="<?php echo BASE_URL . '/Vista/Paginas/sobreEmpresa.php'; ?>" class="text-white text-decoration-none mx-2">Sobre Empresa</a>
        </div>

        <div class="d-flex justify-content-center">
            <a class="btn btn-outline-light btn-floating m-1" href="#" role="button" aria-label="Facebook">
                <i class="bi bi-facebook"></i>
            </a>
            <a class="btn btn-outline-light btn-floating m-1" href="#" role="button" aria-label="Instagram">
                <i class="bi bi-instagram"></i>
            </a>
            <a class="btn btn-outline-light btn-floating m-1" href="#" role="button" aria-label="WhatsApp">
                <i class="bi bi-whatsapp"></i>
            </a>
        </div>
    </div>
</footer>


<?php include (INCLUDES_PATH."scripts.php"); ?>

</body>
</html>
