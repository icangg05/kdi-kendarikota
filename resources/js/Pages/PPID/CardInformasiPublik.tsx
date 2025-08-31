import { Card } from "@/Components/card";
import { Link } from "@inertiajs/react";
import { Calendar, Clock, Volume2 } from "lucide-react";
import CardJenisInformasi from "./CardJenisInformasi";

export default function CardInformasiPublik() {
  return (
    <>
      <Card className="rounded-2xl shadow-md p-6 mb-6">
        <h2 className="text-lg font-semibold mb-2">Daftar Informasi Publik</h2>
        <p className="text-sm text-gray-600 mb-4">
          Salah satu kewajiban badan publik yang dinyatakan dalam Undang-Undang
          No 14 Tahun 2008 adalah menyediakan Daftar Informasi Publik (DIP). DIP
          adalah catatan yang berisi keterangan sistematis tentang informasi
          publik yang berada di bawah penguasaan badan publik. Melalui aplikasi
          PPID Pemerintah Kota Kendari yang digunakan ini, badan publik dapat
          mempublikasi informasi yang dikuasai yang selanjutnya tersusun sebagai
          DIP secara otomatis.
        </p>
      </Card>
      {/* Cards */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <Link href={route("menuPPIDJenisInformasi", "informasi-berkala")}>
          <CardJenisInformasi
            icon={<Clock className="w-8 h-8" />}
            title="Informasi Berkala"
            bgColor="bg-blue-100"
            textColor="text-blue-600"
          />
        </Link>
        <Link href={route("menuPPIDJenisInformasi", "informasi-serta-merta")}>
          <CardJenisInformasi
            icon={<Volume2 className="w-8 h-8" />}
            title="Informasi Serta Merta"
            bgColor="bg-green-100"
            textColor="text-green-600"
          />
        </Link>
        <Link href={route("menuPPIDJenisInformasi", "informasi-setiap-saat")}>
          <CardJenisInformasi
            icon={<Calendar className="w-8 h-8" />}
            title="Informasi Setiap Saat"
            bgColor="bg-purple-100"
            textColor="text-purple-600"
          />
        </Link>
      </div>
    </>
  );
}
