import { Card } from "@/Components/card";
import { Link } from "@inertiajs/react";

export default function CardPengajuanKeberatan() {
  return (
    <Card className="rounded-2xl shadow-md p-6">
      <h2 className="text-lg font-semibold mb-2">Pengajuan Keberatan</h2>
      <p className="text-sm text-gray-600 mb-4">
        Layanan ini disediakan bagi pemohon informasi publik yang{" "}
        <span className="font-medium">merasa keberatan</span> atas tanggapan
        atau jawaban yang diberikan oleh PPID Kota Kendari. Silakan ajukan
        keberatan melalui form resmi agar dapat ditindaklanjuti sesuai
        ketentuan.
      </p>

      {/* Tombol Ajukan Keberatan */}
      <Link
        href={route("form-keberatan")}
        className="text-xs px-5 py-2 bg-[#1B3C60] text-white font-semibold rounded shadow-md hover:bg-[#254a73] transition"
      >
        Ajukan Keberatan
      </Link>
    </Card>
  );
}
