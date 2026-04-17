<?php
namespace Dao\Products;

use Dao\Table;

class Products extends Table {
    
    /**
     * 1. Para el Panel de Administración
     */
    public static function getAllProducts() {
        $sqlstr = "SELECT * FROM productos;";
        return self::obtenerRegistros($sqlstr, []);
    }

    /**
     * 2. SOLUCIÓN ERROR CATEGORÍAS
     * Muestra productos por categoría (Amor, Cumpleaños, etc.)
     */
    public static function getProductsByCategory($categorySlug) {
        $slug = strtolower($categorySlug);
        $catMap = [
            "amor" => 1, "cumpleaños" => 2, "cumple" => 2,
            "graduación" => 3, "grad" => 3, "ramos" => 4,
            "caballeros" => 5, "condolencias"=> 6, "mama" => 7, "premium" => 8
        ];
        $catId = $catMap[$slug] ?? 1;
        $sqlstr = "SELECT * FROM productos WHERE id_categoria = :catId AND estado = 'disponible';";
        return self::obtenerRegistros($sqlstr, ["catId" => $catId]);
    }

    /**
     * 3. SOLUCIÓN ERROR PÁGINA INICIO
     * Productos destacados
     */
    public static function getDailyDeals() {
        $sqlstr = "SELECT * FROM productos WHERE estado = 'disponible' LIMIT 4;";
        return self::obtenerRegistros($sqlstr, []);
    }

    /**
     * 4. Para ver detalles de un solo arreglo
     */
    public static function getProductById($id) {
        $sqlstr = "SELECT * FROM productos WHERE id_producto = :id;";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }

    /**
     * 5. INSERTAR (Sincronizado con tu controlador)
     * Orden: nombre, dsc, precio, imagen, estado, stock, cat
     */
    public static function insertProduct($nombre, $descripcion, $precio, $imagen, $estado, $stock, $id_categoria) {
        $sqlstr = "INSERT INTO productos (nombre, descripcion, precio, imagen, estado, stock, id_categoria) 
                   VALUES (:nombre, :descripcion, :precio, :imagen, :estado, :stock, :id_categoria);";
        
        return self::executeNonQuery($sqlstr, [
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio" => $precio,
            "imagen" => $imagen,
            "estado" => $estado,
            "stock" => $stock,
            "id_categoria" => $id_categoria
        ]);
    }

    /**
     * 6. ACTUALIZAR
     */
    public static function updateProduct($id_producto, $nombre, $descripcion, $precio, $imagen, $estado, $stock, $id_categoria) {
        $sqlstr = "UPDATE productos SET 
                   nombre=:nombre, descripcion=:descripcion, precio=:precio, 
                   imagen=:imagen, estado=:estado, stock=:stock, id_categoria=:id_categoria 
                   WHERE id_producto=:id_producto;";
        
        return self::executeNonQuery($sqlstr, [
            "id_producto" => $id_producto,
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio" => $precio,
            "imagen" => $imagen,
            "estado" => $estado,
            "stock" => $stock,
            "id_categoria" => $id_categoria
        ]);
    }
}