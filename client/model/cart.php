<?php
class Cart extends BaseModel
{
    protected $table = 'carts';

    /** Lấy giỏ hàng của user */
    public function getCartByUser(int $userId): ?array
    {
        $this->setTable($this->table);
        return $this->select('*', 'userId = ?', [$userId])[0] ?? null;
    }

    /** Tạo giỏ hàng mới cho user */
    public function createCart(int $userId)
    {
        $this->setTable($this->table);
        return $this->insert([
            'userId' => $userId,
            'total' => 0
        ]);
    }

    /** Lấy sản phẩm trong giỏ của 1 cartId + variantId */
    public function getCartProduct(int $cartId, int $variantId): ?array
    {
        $this->setTable('cart_products');
        return $this->select('*', 'cartId = ? AND variantId = ?', [$cartId, $variantId])[0] ?? null;
    }

    /** Thêm hoặc tăng số lượng sản phẩm vào giỏ */
    public function addProduct(int $cartId, int $productId, int $variantId, int $quantity, float $price): void
    {
        $exist = $this->getCartProduct($cartId, $variantId);

        $this->setTable('cart_products');

        if ($exist) {
            $newQty = $exist['quantity'] + $quantity;
            $this->update([
                'quantity' => $newQty,
                'price' => $price
            ], 'id = :id', ['id' => $exist['id']]);
        } else {
            $this->insert([
                'cartId' => $cartId,
                'productId' => $productId,
                'variantId' => $variantId,
                'quantity' => $quantity,
                'price' => $price
            ]);
        }

        $this->updateCartTotal($cartId);
    }

    /** Cập nhật tổng tiền giỏ hàng */
    public function updateCartTotal(int $cartId): void
    {
        $sql = "SELECT SUM(quantity * price) AS total FROM cart_products WHERE cartId = ?";
        $total = $this->selectRaw($sql, [$cartId])[0]['total'] ?? 0;

        // Reset table về carts trước khi update
        $this->setTable('carts');
        $this->update(['total' => $total], 'id = :id', ['id' => $cartId]);
    }


    /** Lấy chi tiết giỏ hàng theo userId */
    public function getCartDetails(int $userId): array
    {
        $sql = "
           SELECT 
            cp.id AS cartProductId,
            cp.cartId,
            cp.productId,
            cp.variantId,
            cp.quantity,
            cp.price,
            p.title,
            p.thumbnail AS image,
            GROUP_CONCAT(DISTINCT av.value SEPARATOR ', ') AS variantAttributes
            FROM carts c
            JOIN cart_products cp ON c.id = cp.cartId
            JOIN products p ON cp.productId = p.id
            LEFT JOIN variants v ON cp.variantId = v.id
            LEFT JOIN variant_values vv ON v.id = vv.variantId
            LEFT JOIN attribute_values av ON vv.valueId = av.id
            WHERE c.userId = ?
            GROUP BY cp.id
        ";
        return $this->selectRaw($sql, [$userId]);
    }
    public function removeProduct(int $cartProductId, int $cartId): void
    {
        // Xóa sản phẩm khỏi cart_products
        $this->setTable('cart_products');
        $this->delete('id = ?', [$cartProductId]);

        // Cập nhật tổng tiền giỏ
        $this->updateCartTotal($cartId);
    }
}
