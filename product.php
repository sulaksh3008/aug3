<?php
class Product {
    public $prodId;
    public $prodName;
    public $prodPrice;

    public function setProdDetails($prodId, $prodName, $prodPrice) {
        $this->prodId = $prodId;
        $this->prodName = $prodName;
        $this->prodPrice = $prodPrice;
    }

    public function displayProdDetails() {
        echo "Product ID: {$this->prodId}, Name: {$this->prodName}, Price: {$this->prodPrice}\n";
    }
}

class MyCart {
    private $products = [];
    private $count = 0;

    public function insert(Product $product) {
        $this->products[] = $product;
        $this->count++;
    }

    public function update($prodId, $newName, $newPrice) {
        foreach ($this->products as $product) {
            if ($product->prodId === $prodId) {
                $product->prodName = $newName;
                $product->prodPrice = $newPrice;
                break;
            }
        }
    }

    public function delete($prodId) {
        for ($i = 0; $i < count($this->products); $i++) {
            if ($this->products[$i]->prodId === $prodId) {
                array_splice($this->products, $i, 1);
                $this->count--;
                break;
            }
        }
    }

    public function search($prodId) {
        foreach ($this->products as $product) {
            if ($product->prodId === $prodId) {
                return $product;
            }
        }
        return null;
    }

    public function sortByProductId() {
        usort($this->products, function ($a, $b) {
            return $a->prodId - $b->prodId;
        });
    }

    public function reverseByProductId() {
        usort($this->products, function ($a, $b) {
            return $b->prodId - $a->prodId;
        });
    }

    public function getCount() {
        return $this->count;
    }

    public function displayCart() {
        foreach ($this->products as $product) {
            $product->displayProdDetails();
        }
    }
}

// Function to get user input for product details
function getProductDetailsFromUser() {
    echo "Enter Product ID: ";
    $prodId = intval(readline());
    echo "Enter Product Name: ";
    $prodName = readline();
    echo "Enter Product Price: ";
    $prodPrice = floatval(readline());
    return [$prodId, $prodName, $prodPrice];
}

// Main program
$myCart = new MyCart();

while (true) {
    echo "1. Insert 2. Update 3. Delete 4. Search 5. Display 6. Sort By productId 7. Reverse by productId 8. Exit\n";
    echo "Enter your choice: ";
    $choice = intval(readline());

    switch ($choice) {
        case 1:
            list($prodId, $prodName, $prodPrice) = getProductDetailsFromUser();
            $product = new Product();
            $product->setProdDetails($prodId, $prodName, $prodPrice);
            $myCart->insert($product);
            break;
        case 2:
            echo "Enter Product ID to update: ";
            $prodId = intval(readline());
            list($prodId,$prodName, $prodPrice) = getProductDetailsFromUser();
            $myCart->update($prodId, $prodName, $prodPrice);
            break;
        case 3:
            echo "Enter Product ID to delete: ";
            $prodId = intval(readline());
            $myCart->delete($prodId);
            break;
        case 4:
            echo "Enter Product ID to search: ";
            $prodId = intval(readline());
            $product = $myCart->search($prodId);
            if ($product !== null) {
                $product->displayProdDetails();
            } else {
                echo "Product not found.\n";
            }
            break;
        case 5:
            $myCart->displayCart();
            break;
        case 6:
            $myCart->sortByProductId();
            break;
        case 7:
            $myCart->reverseByProductId();
            break;
        case 8:
            exit("Exiting program.\n");
        default:
            echo "Invalid choice. Please try again.\n";
            break;
    }
}
