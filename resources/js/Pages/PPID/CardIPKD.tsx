import { Card } from "@/Components/card";
import { Link } from "@inertiajs/react";
import { Calendar } from "lucide-react";
import CardJenisInformasi from "./CardJenisInformasi";

export default function CardIPKD() {
  return (
    <>
      <Card className="rounded-2xl shadow-md p-6 mb-6">
        <h2 className="text-lg font-semibold mb-2">Dokumen IPKD</h2>
        <p className="text-sm text-gray-600 mb-4">
          Indikator Pelayanan Kinerja Daerah (IPKD) merupakan sistem pengukuran
          kinerja pemerintah daerah yang mencakup aspek pelayanan publik, tata
          kelola, dan akuntabilitas. Dokumen ini berisi kumpulan indikator yang
          digunakan untuk menilai efektivitas dan efisiensi penyelenggaraan
          pemerintahan Kota Kendari dalam memberikan pelayanan kepada
          masyarakat.
        </p>
      </Card>
      {/* Cards */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <Link href={route("menu-ipkd", "2024")}>
          <CardJenisInformasi
            icon={<Calendar className="w-8 h-8" />}
            title="Tahun 2024"
            bgColor="bg-blue-100"
            textColor="text-blue-600"
          />
        </Link>
        <Link href={route("menu-ipkd", "2023")}>
          <CardJenisInformasi
            icon={<Calendar className="w-8 h-8" />}
            title="Tahun 2023"
            bgColor="bg-blue-100"
            textColor="text-blue-600"
          />
        </Link>
      </div>
    </>
  );
}
