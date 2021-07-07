<?php

namespace Modules\Vaksinasi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Vaksinasi\Entities\Squad;
use Illuminate\Support\Str;

class SquadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Squad::create([
            'name' => 'KOREM 081',
            'code' => 'KRM081',
            'vaccine_target' => 5000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0801/PACITAN',
            'code' => 'KDM0801',
            'vaccine_target' => 5000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0802/PONOROGO',
            'code' => 'KDM0802',
            'vaccine_target' => 5000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0803/MADIUN',
            'code' => 'KDM0803',
            'vaccine_target' => 5000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0804/MAGETAN',
            'code' => 'KDM0804',
            'vaccine_target' => 5000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0805/NGAWI',
            'code' => 'KDM0805',
            'vaccine_target' => 5000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0806/TRENGGALEK',
            'code' => 'KDM0806',
            'vaccine_target' => 5000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0807/TULUNGAGUNG',
            'code' => 'KDM0807',
            'vaccine_target' => 5000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0808/BLITAR',
            'code' => 'KDM0808',
            'vaccine_target' => 5000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0810/NGANJUK',
            'code' => 'KDM0810',
            'vaccine_target' => 5000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KOREM 082/CPYJ',
            'code' => 'KRM082',
            'vaccine_target' => 4000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0809/KEDIRI',
            'code' => 'KDM0809',
            'vaccine_target' => 4000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0811/TUBAN',
            'code' => 'KDM0811',
            'vaccine_target' => 2000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0812/LAMONGAN',
            'code' => 'KDM0812',
            'vaccine_target' => 2000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0813/BOJONEGORO',
            'code' => 'KDM0813',
            'vaccine_target' => 2000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0814/JOMBANG',
            'code' => 'KDM0814',
            'vaccine_target' => 2000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0815/MOJOKERTO',
            'code' => 'KDM0815',
            'vaccine_target' => 2500,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KOREM 083/BDJ',
            'code' => 'KRM083',
            'vaccine_target' => 2000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0818/MALANG-BATU',
            'code' => 'KDM0818',
            'vaccine_target' => 6000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0819/PASURUAN',
            'code' => 'KDM0819',
            'vaccine_target' => 6000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0820/PROBOLINGGO',
            'code' => 'KDM0820',
            'vaccine_target' => 3500,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0821/LUMAJANG',
            'code' => 'KDM0821',
            'vaccine_target' => 10000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0822 BONDOWOSO',
            'code' => 'KDM0822',
            'vaccine_target' => 3000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0823/SITUBONDO',
            'code' => 'KDM0823',
            'vaccine_target' => 2700,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0824/JEMBER',
            'code' => 'KDM0824',
            'vaccine_target' => 6000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0825 BANYUWANGI',
            'code' => 'KDM0825',
            'vaccine_target' => 1000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0833/KOTA MALANG',
            'code' => 'KDM0833',
            'vaccine_target' => 8000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KOREM 084/BJ',
            'code' => 'KRM084',
            'vaccine_target' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0816/SIDOARJO',
            'code' => 'KDM0816',
            'vaccine_target' => 6000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0817/GRESIK',
            'code' => 'KDM0817',
            'vaccine_target' => 6000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0826/PAMEKASAN',
            'code' => 'KDM0826',
            'vaccine_target' => 6000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0827/SUMENEP',
            'code' => 'KDM0827',
            'vaccine_target' => 3000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0828/SAMPANG',
            'code' => 'KDM0828',
            'vaccine_target' => 2730,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0829/BANGKALAN',
            'code' => 'KDM0829',
            'vaccine_target' => 4300,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0830/SBY UTARA',
            'code' => 'KDM0830',
            'vaccine_target' => 6000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0831/SBY TIMUR',
            'code' => 'KDM0831',
            'vaccine_target' => 6000,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Squad::create([
            'name' => 'KODIM 0832/SBY SELATAN',
            'code' => 'KDM0832',
            'vaccine_target' => 4200,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}