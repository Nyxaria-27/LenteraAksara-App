<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('abouts')->truncate();
        
        DB::table('abouts')->insert([
            'title' => 'Tentang Kami: Lentera Aksara',
            'content' => '<div class="dark:text-gray-100" style="line-height: 1.8; color: #333;">
    <h2 class="dark:text-[#9acd32]" style="color: #4B5320; font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">Tentang Kami: Lentera Aksara</h2>
    <p class="dark:text-gray-200" style="margin-bottom: 1.5rem; font-size: 1.1rem;">
        Selamat datang di <strong class="dark:text-gray-100" style="color: #2F4F4F;">Lentera Aksara</strong>, sebuah ruang yang didirikan atas dasar kecintaan yang mendalam terhadap dunia literasi dan kekuatan narasi. Kami percaya bahwa setiap buku adalah sebuah lentera yang mampu menerangi lorong-lorong pikiran, menawarkan panduan, inspirasi, dan koneksi ke dunia yang tak terbatas.
    </p>

    <hr class="dark:opacity-50" style="border: 0; height: 2px; background: linear-gradient(to right, #D2B48C, #4B5320, #D2B48C); margin: 2rem 0;">

    <h3 class="dark:text-gray-100" style="color: #2F4F4F; font-size: 1.5rem; font-weight: 600; margin: 2rem 0 1rem;">🌟 Filosofi dan Visi Kami</h3>
    <p class="dark:text-gray-200" style="margin-bottom: 1rem;">
        Nama <strong>Lentera Aksara</strong> bukan hanya sekadar identitas; ia adalah manifestasi dari visi kami. Kata <strong class="dark:text-[#9acd32]" style="color: #4B5320;">"Lentera"</strong> melambangkan harapan, pencerahan, dan penemuan. Kami ingin setiap pengunjung, baik yang baru mengenal buku maupun kutu buku sejati, menemukan secercah cahaya baru dalam setiap halaman yang mereka buka.
    </p>
    <p class="dark:text-gray-200" style="margin-bottom: 1.5rem;">
        Sementara itu, <strong class="dark:text-[#9acd32]" style="color: #4B5320;">"Aksara"</strong> adalah fondasi dari segala pengetahuan. Di sini, ribuan aksara terjalin menjadi kisah, ilmu, dan imajinasi. Visi kami adalah menjadi bukan hanya sekadar toko buku, melainkan sebuah <strong>Hub Literasi</strong> yang aktif, tempat di mana ide-ide bersemi, diskusi bergaung, dan komunitas pembaca tumbuh subur.
    </p>

    <h3 class="dark:text-gray-100" style="color: #2F4F4F; font-size: 1.5rem; font-weight: 600; margin: 2rem 0 1rem;">📖 Sejarah Singkat</h3>
    <p class="dark:text-gray-200" style="margin-bottom: 1rem;">
        Lentera Aksara lahir dari mimpi sederhana dua orang sahabat pada tahun <strong>2015</strong> di sebuah sudut kota yang tenang. Mereka menyadari adanya kebutuhan akan sebuah tempat yang tidak hanya menjual buku, tetapi juga menawarkan pengalaman. Berawal dari rak buku kecil yang dikurasi dengan hati-hati, Lentera Aksara berkembang pesat, didorong oleh prinsip bahwa <em>kualitas lebih penting daripada kuantitas</em>.
    </p>
    <p class="dark:text-gray-200" style="margin-bottom: 1.5rem;">
        Seiring waktu, kami memperluas koleksi kami, menjalin kemitraan dengan penerbit independen, dan yang terpenting, membangun komunitas yang setia. Setiap desain interior toko kami, dari rak kayu yang hangat hingga sudut baca yang nyaman, dirancang untuk menciptakan suasana yang intim dan mendukung petualangan membaca Anda.
    </p>

    <h3 class="dark:text-gray-100" style="color: #2F4F4F; font-size: 1.5rem; font-weight: 600; margin: 2rem 0 1rem;">📚 Kurasi Koleksi Kami</h3>
    <p class="dark:text-gray-200" style="margin-bottom: 1rem;">
        Di Lentera Aksara, kami bangga dengan proses kurasi koleksi kami. Kami tidak hanya menumpuk buku terlaris. Tim kurator kami dengan cermat memilih buku-buku dari berbagai genre—mulai dari sastra klasik yang abadi, fiksi kontemporer yang berani, puisi yang menyentuh jiwa, hingga buku non-fiksi mendalam yang memperkaya wawasan.
    </p>
    <ul class="dark:text-gray-200" style="list-style: none; padding-left: 0; margin-bottom: 1.5rem;">
        <li style="margin-bottom: 0.8rem; padding-left: 1.5rem; position: relative;">
            <span class="dark:text-[#9acd32]" style="position: absolute; left: 0; color: #4B5320; font-weight: bold;">✦</span>
            <strong class="dark:text-gray-100" style="color: #2F4F4F;">Fiksi Global & Lokal:</strong> Kami merayakan keragaman suara, menampilkan penulis-penulis ternama dan talenta lokal yang sedang naik daun.
        </li>
        <li style="margin-bottom: 0.8rem; padding-left: 1.5rem; position: relative;">
            <span class="dark:text-[#9acd32]" style="position: absolute; left: 0; color: #4B5320; font-weight: bold;">✦</span>
            <strong class="dark:text-gray-100" style="color: #2F4F4F;">Karya Langka & Terkurasi:</strong> Seringkali Anda akan menemukan edisi khusus, terbitan terbatas, atau buku dari penerbit independen yang sulit ditemukan di tempat lain.
        </li>
        <li style="margin-bottom: 0.8rem; padding-left: 1.5rem; position: relative;">
            <span class="dark:text-[#9acd32]" style="position: absolute; left: 0; color: #4B5320; font-weight: bold;">✦</span>
            <strong class="dark:text-gray-100" style="color: #2F4F4F;">Sesi Diskusi & Acara:</strong> Kami secara rutin menyelenggarakan bedah buku, sesi tanda tangan penulis, dan lokakarya literasi, menjadikan toko kami pusat interaksi budaya.
        </li>
    </ul>

    <h3 class="dark:text-gray-100" style="color: #2F4F4F; font-size: 1.5rem; font-weight: 600; margin: 2rem 0 1rem;">🤝 Komitmen Kami</h3>
    <p class="dark:text-gray-200" style="margin-bottom: 1rem;">
        Komitmen utama Lentera Aksara adalah kepada para pembaca. Kami berjanji untuk:
    </p>
    <blockquote class="dark:bg-gray-800 dark:border-[#9acd32] bg-[#F5F5F5]" style="border-left: 5px solid #4B5320; padding: 1.5rem; margin: 1.5rem 0; font-style: italic; color: #2F4F4F; border-radius: 0 8px 8px 0;">
        <span class="dark:text-gray-200">"Menyediakan lingkungan yang tenang, inspiratif, dan ramah, di mana setiap individu dapat menemukan buku yang \'memanggil\' mereka, dan merasakan koneksi yang mendalam dengan dunia kata-kata."</span>
    </blockquote>

    <h3 class="dark:text-gray-100" style="color: #2F4F4F; font-size: 1.5rem; font-weight: 600; margin: 2rem 0 1rem;">💡 Mengapa Memilih Lentera Aksara?</h3>
    <ul class="dark:text-gray-200" style="list-style: none; padding-left: 0; margin-bottom: 1.5rem;">
        <li style="margin-bottom: 0.8rem; padding-left: 1.5rem; position: relative;">
            <span class="dark:text-[#9acd32]" style="position: absolute; left: 0; color: #4B5320; font-size: 1.2rem;">✓</span>
            <strong>Koleksi Pilihan:</strong> Setiap buku dipilih dengan pertimbangan matang untuk kualitas dan relevansinya.
        </li>
        <li style="margin-bottom: 0.8rem; padding-left: 1.5rem; position: relative;">
            <span class="dark:text-[#9acd32]" style="position: absolute; left: 0; color: #4B5320; font-size: 1.2rem;">✓</span>
            <strong>Komunitas Aktif:</strong> Bergabunglah dengan diskusi, klub buku, dan acara-acara literasi kami.
        </li>
        <li style="margin-bottom: 0.8rem; padding-left: 1.5rem; position: relative;">
            <span class="dark:text-[#9acd32]" style="position: absolute; left: 0; color: #4B5320; font-size: 1.2rem;">✓</span>
            <strong>Layanan Personal:</strong> Tim kami siap membantu Anda menemukan buku yang sempurna sesuai minat Anda.
        </li>
        <li style="margin-bottom: 0.8rem; padding-left: 1.5rem; position: relative;">
            <span class="dark:text-[#9acd32]" style="position: absolute; left: 0; color: #4B5320; font-size: 1.2rem;">✓</span>
            <strong>Pengalaman Belanja:</strong> Platform online yang mudah digunakan dengan pengiriman cepat dan aman.
        </li>
        <li style="margin-bottom: 0.8rem; padding-left: 1.5rem; position: relative;">
            <span class="dark:text-[#9acd32]" style="position: absolute; left: 0; color: #4B5320; font-size: 1.2rem;">✓</span>
            <strong>Dukungan Penulis Lokal:</strong> Kami bangga mendukung dan mempromosikan karya-karya penulis Indonesia.
        </li>
    </ul>

    <h3 class="dark:text-gray-100" style="color: #2F4F4F; font-size: 1.5rem; font-weight: 600; margin: 2rem 0 1rem;">🌏 Visi Masa Depan</h3>
    <p class="dark:text-gray-200" style="margin-bottom: 1rem;">
        Kami terus berinovasi untuk memberikan pengalaman literasi terbaik. Dalam waktu dekat, kami berencana untuk:
    </p>
    <ul class="dark:text-gray-200" style="margin-bottom: 1.5rem; padding-left: 1.5rem;">
        <li style="margin-bottom: 0.5rem;">Meluncurkan program beasiswa buku untuk pelajar berprestasi</li>
        <li style="margin-bottom: 0.5rem;">Membuka cabang fisik di berbagai kota</li>
        <li style="margin-bottom: 0.5rem;">Mengadakan festival literasi tahunan</li>
        <li style="margin-bottom: 0.5rem;">Memperluas koleksi e-book dan audiobook</li>
    </ul>

    <div class="dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900" style="background: linear-gradient(135deg, #4B5320 0%, #2F4F4F 100%); color: white; padding: 2rem; border-radius: 12px; margin: 2rem 0; text-align: center;">
        <p class="dark:text-gray-100" style="font-size: 1.2rem; margin: 0; font-style: italic; line-height: 1.6;">
            "Terima kasih telah menjadi bagian dari perjalanan Lentera Aksara.<br>
            Mari terus menerangi dunia, <strong class="dark:text-[#9acd32]">satu halaman pada satu waktu</strong>."
        </p>
    </div>

    <p class="dark:text-gray-400" style="text-align: center; color: #666; margin-top: 2rem; font-size: 0.95rem;">
        <em>— Tim Lentera Aksara, 2015 - Sekarang —</em>
    </p>
</div>',
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
