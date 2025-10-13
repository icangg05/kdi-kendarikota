import { Card, CardContent } from "@/Components/card";
import {
  FileText,
  Mail,
  Download,
  Eye,
  Calendar,
  Bell,
  Clock,
  CheckCircle,
  XCircle,
} from "lucide-react";

type StatistikItem = {
  label: string;
  value: number | string;
  icon: React.ReactNode;
};

export default function CardStatistikPPID({
  jumlahDokumen,
  jumlahPermohonanInformasi,
  jumlahPermohonanDiterima,
  jumlahPermohonanDitolak,
  jumlahUnduhan,
  jumlahLihat,
  jumlahBerkala,
  jumlahSertaMerta,
  jumlahSetiapSaat,
}: any) {
  const data: StatistikItem[] = [
    {
      label: "Jumlah Dokumen",
      value: jumlahDokumen,
      icon: <FileText className="w-6 h-6 text-blue-600" />,
    },
    {
      label: "Jumlah Permohonan Informasi",
      value: jumlahPermohonanInformasi,
      icon: <Mail className="w-6 h-6 text-green-600" />,
    },
    {
      label: "Jumlah Permohonan Diterima",
      value: jumlahPermohonanDiterima,
      icon: <CheckCircle className="w-6 h-6 text-emerald-600" />,
    },
    {
      label: "Jumlah Permohonan Ditolak",
      value: jumlahPermohonanDitolak,
      icon: <XCircle className="w-6 h-6 text-rose-600" />,
    },
    {
      label: "Jumlah Unduhan",
      value: jumlahUnduhan,
      icon: <Download className="w-6 h-6 text-indigo-600" />,
    },
    {
      label: "Jumlah Dokumen Dilihat",
      value: jumlahLihat,
      icon: <Eye className="w-6 h-6 text-purple-600" />,
    },
    {
      label: "Jumlah Informasi Berkala",
      value: jumlahBerkala,
      icon: <Calendar className="w-6 h-6 text-orange-600" />,
    },
    {
      label: "Jumlah Informasi Serta Merta",
      value: jumlahSertaMerta,
      icon: <Bell className="w-6 h-6 text-red-600" />,
    },
    {
      label: "Jumlah Informasi Setiap Saat",
      value: jumlahSetiapSaat,
      icon: <Clock className="w-6 h-6 text-teal-600" />,
    },
  ];

  return (
    <div className="mt-6 lg:mt-7 p-6 bg-white rounded-2xl shadow-md">
      <h2 className="text-lg font-semibold mb-2">Statistik</h2>
      <p className="text-sm text-gray-600 mb-6">Informasi statistik dokumen</p>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">
        {data.map((item, i) => (
          <Card
            key={i}
            className={`flex items-center gap-4 p-6 shadow-sm ${
              i < 6
                ? "sm:col-span-2 lg:col-span-3"
                : "sm:col-span-1 lg:col-span-2"
            }`}
          >
            <div className="p-4 rounded-full bg-gray-100">{item.icon}</div>
            <CardContent className="p-0">
              <p className="text-sm text-gray-500">{item.label}</p>
              <p className="text-2xl font-bold">
                {Number(item.value).toLocaleString("id-ID")}
              </p>
            </CardContent>
          </Card>
        ))}
      </div>
    </div>
  );
}
