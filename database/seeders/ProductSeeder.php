<?php
namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Seeder;
class ProductSeeder extends Seeder {
    public function run(): void {
        $d = [
          ['Mangrove Bakau','Rhizophora mucronata','Mangrove',15000,22],
          ['Mangrove Api-api','Avicennia marina','Mangrove',15000,20],
          ['Mangrove Pedada','Sonneratia alba','Mangrove',18000,21],
          ['Mangrove Tancang','Bruguiera gymnorhiza','Mangrove',17000,21],
          ['Beringin','Ficus benjamina','Peneduh',45000,28],
          ['Trembesi','Samanea saman','Peneduh',35000,48],
          ['Mahoni','Swietenia mahagoni','Kayu',20000,30],
          ['Jati','Tectona grandis','Kayu',25000,25],
          ['Sengon','Falcataria moluccana','Kayu',12000,35],
          ['Tabebuya','Tabebuia rosea','Hias',40000,18]
        ];
        foreach ($d as [$n,$l,$t,$p,$c]) Product::create([
          'name'=>"Bibit $n",'latin'=>$l,'type'=>$t,'price'=>$p,'co2'=>$c,
          'description'=>"Bibit $n ($l) tinggi ±30–60 cm, sehat dan siap tanam. Estimasi serapan CO₂ saat dewasa ≈ $c kg/tahun (perkiraan edukatif).",
        ]);
    }
}
