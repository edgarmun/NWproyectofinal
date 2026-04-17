<?php
namespace Controllers\Admin;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Products\Products as ProductsModel;
use Utilities\Site;

class ProductForm extends PublicController {
    public function run(): void {
        $viewData = [
            "mode_dsc" => "Agregar Nuevo Producto",
            "error" => ""
        ];

        if ($this->isPostBack()) {
            // 1. CAPTURA DE DATOS
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $precio = (float)$_POST["precio"];
            $stock  = (int)$_POST["stock"];
            $id_categoria = (int)$_POST["id_categoria"];
            $estado = "disponible";
            $imagen = "default.jpg";

            // 2. VALIDACIÓN DE STOCK
            if ($stock < 0) {
                $viewData["error"] = "El stock no puede ser negativo.";
            } else {
                // Manejo de la subida de imagen
                if (isset($_FILES["imagen_file"]) && $_FILES["imagen_file"]["name"] !== "") {
                    $nom_archivo = time() . "_" . $_FILES["imagen_file"]["name"];
                    // Asegúrate de que esta carpeta exista en tu servidor
                    if (move_uploaded_file($_FILES["imagen_file"]["tmp_name"], "public/img/productos/" . $nom_archivo)) {
                        $imagen = $nom_archivo;
                    }
                }

                // 3. INSERCIÓN (Ordenado: nombre, dsc, precio, img, estado, stock, cat)
                ProductsModel::insertProduct(
                    $nombre, 
                    $descripcion, 
                    $precio, 
                    $imagen, 
                    $estado, 
                    $stock, 
                    $id_categoria
                );
                
                Site::redirectTo("index.php?page=Admin_Productos");
                return;
            }
        }

        Renderer::render("admin/product_form", $viewData);
    }
}