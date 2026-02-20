-- =====================================================
-- EJERCICIO SQL: PRODUCTOS
-- =====================================================

-- 1. Crear y seleccionar la base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS ejercicio_productos;
USE ejercicio_productos;

-- 2. Crear la tabla productos con los campos indicados
CREATE TABLE productos (
    id_fabricante VARCHAR(10) NOT NULL,
    id_producto   VARCHAR(10) NOT NULL,
    descripcion   VARCHAR(100) NOT NULL,
    precio        DECIMAL(10,2) NOT NULL,
    existencia    INT NOT NULL,
    PRIMARY KEY (id_fabricante, id_producto)
);

-- 3. Insertar los datos proporcionados
INSERT INTO productos (id_fabricante, id_producto, descripcion, precio, existencia) VALUES
('Aci', '41001', 'Aguja', 58, 227),
('Aci', '41002', 'Micropore', 80, 150),
('Aci', '41003', 'Gasa', 112, 80),
('Aci', '41004', 'Equipo macrogoteo', 110, 50),
('Bic', '41003', 'Curas', 120, 20),
('Inc', '41089', 'Canaleta', 500, 30),
('Qsa', 'Xk47', 'Compresa', 150, 200),
('Bic', 'Xk47', 'Compresa', 200, 200);

-- =====================================================
-- CONSULTAS SOLICITADAS
-- =====================================================

-- a) Lista de todos los productos con precio e IVA incluido (10%)
SELECT 
    id_fabricante,
    id_producto,
    descripcion,
    precio,
    ROUND(precio * 1.10, 2) AS precio_con_iva
FROM productos;

-- b) Cantidad total de existencias por producto
--    (cada producto ya tiene su existencia individual)
SELECT 
    id_fabricante,
    id_producto,
    descripcion,
    existencia
FROM productos;

-- c) Promedio de precio por fabricante
SELECT 
    id_fabricante,
    ROUND(AVG(precio), 2) AS precio_promedio
FROM productos
GROUP BY id_fabricante;

-- d) Producto con mayor precio (si hay empate, se muestran todos)
SELECT *
FROM productos
WHERE precio = (SELECT MAX(precio) FROM productos);

-- e) Nuevo pedido: aumentar en 500 las existencias de 'Curas' del fabricante 'Bic'
UPDATE productos
SET existencia = existencia + 500
WHERE id_fabricante = 'Bic' AND id_producto = '41003';  -- 'Curas' tiene id_producto '41003'

-- f) Eliminar productos del fabricante 'Osa' (asumimos que es 'Qsa' por similitud en los datos)
--    Si el fabricante no existe, la consulta no afectará ninguna fila.
DELETE FROM productos
WHERE id_fabricante = 'Qsa';  -- Cambiar a 'Osa' si corresponde

-- =====================================================
-- VERIFICACIÓN FINAL (opcional)
-- =====================================================
-- Mostrar todos los productos después de las operaciones
SELECT * FROM productos;