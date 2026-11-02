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
          ['Tabebuya','Tabebuia rosea','Hias',40000,18],
          ['Ketapang Kencana','Terminalia mantaly','Peneduh',30000,20],
          ['Kemiri','Aleurites moluccanus','Kayu',22000,22],
          ['Matoa','Pometia pinnata','Buah',60000,24],
          ['Durian','Durio zibethinus','Buah',85000,26],
          ['Mangga','Mangifera indica','Buah',50000,23],
          ['Alpukat','Persea americana','Buah', 55000,20],
          ['Bambu Petung','Dendrocalamus asper','Konservasi',25000,40],
          ['Cemara Laut','Casuarina equisetifolia','Pesisir',18000,19],
          ['Kelapa Genjah','Cocos nucifera','Pesisir',40000,17],
          ['Pule','Alstonia scholaris','Peneduh',28000,21],
          ['Gaharu','Aquilaria malaccensis','Konservasi',120000,18],
          ['Sukun','Artocarpus altilis','Buah',35000,22],
        ];
        foreach ($d as [$n,$l,$t,$p,$c]) Product::create([
          'name'=>"Bibit $n",'latin'=>$l,'type'=>$t,'price'=>$p,'co2'=>$c,
          'description'=>"Bibit $n ($l) tinggi ±30–60 cm, sehat dan siap tanam. Estimasi serapan CO₂ saat dewasa ≈ $c kg/tahun (perkiraan edukatif).",
        ]);
    }
}
