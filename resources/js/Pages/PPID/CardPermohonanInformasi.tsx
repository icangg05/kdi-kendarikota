import { Card } from "@/Components/card";
import { Link } from "@inertiajs/react";

export default function CardPermohonanInformasi() {
  return (
    <Card className="rounded-2xl shadow-md p-6">
      <h2 className="text-lg font-semibold mb-2">Permohonan Informasi</h2>
      <p className="text-sm text-gray-600 mb-4">
        Layanan permohonan informasi publik disediakan untuk masyarakat yang
        ingin mengakses informasi secara resmi dari Pemerintah Kota Kendari.
        Silakan ajukan permohonan melalui form yang tersedia.
      </p>

      {/* Tombol Ajukan Permohonan */}
      <Link
        href={route("menuPPIDFormPermohonan")}
        className="text-xs px-5 py-2 bg-[#1B3C60] text-white font-semibold rounded shadow-md hover:bg-[#254a73] transition"
      >
        Ajukan Permohonan
      </Link>
    </Card>
  );
}
