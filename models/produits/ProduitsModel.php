<?php
declare(strict_types=1);

namespace models\produits;
use models\Model;
use PDO;
use InvalidArgumentException;

require_once __DIR__ . "/../Model.php";

class ProduitsModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProducts(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM produits ORDER BY id_produit DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductById(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        $stmt = $this->db->prepare('SELECT * FROM produits WHERE id_produit = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    private function validateProductData(string $nom, float $prix): void
    {
        if (trim($nom) === '') {
            throw new InvalidArgumentException('Le nom du produit est requis.');
        }

        if ($prix < 0) {
            throw new InvalidArgumentException('Le prix doit être positif.');
        }
    }

    public function addProduct(string $nom, string $description, float $prix, ?string $image = null): bool
    {
        $this->validateProductData($nom, $prix);

        $imageToSave = $image ?? 'not_found.jpg';

        $stmt = $this->db->prepare('INSERT INTO produits (nom_produit, description_produit, prix_produit, produit_image) VALUES (?, ?, ?, ?)');

        return $stmt->execute([$nom, $description, $prix, $imageToSave]);
    }

    public function updateProduct(int $id, string $nom, string $description, float $prix, ?string $image = null): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Identifiant de produit invalide.');
        }

        $this->validateProductData($nom, $prix);

        if ($image !== null) {
            $stmt = $this->db->prepare('UPDATE produits SET nom_produit = ?, description_produit = ?, prix_produit = ?, produit_image = ? WHERE id_produit = ?');
            return $stmt->execute([$nom, $description, $prix, $image, $id]);
        }

        $stmt = $this->db->prepare('UPDATE produits SET nom_produit = ?, description_produit = ?, prix_produit = ? WHERE id_produit = ?');
        return $stmt->execute([$nom, $description, $prix, $id]);
    }

    public function deleteProduct(int $id): bool
    {
        if ($id <= 0) {
            return false;
        }

        $stmt = $this->db->prepare('DELETE FROM produits WHERE id_produit = ?');
        return $stmt->execute([$id]);
    }
}
