import { useEffect, useState } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import PageLayout from "@/Layouts/PageLayout";
import {
  Inbox,
  FileText,
  Target,
  User,
  Megaphone,
  ClipboardList,
  Layers,
  BookOpen,
  Search,
  FileQuestion,
  ClipboardCheck,
} from "lucide-react";
import CardInformasiPublik from "./CardInformasiPublik";
import CardPermohonanInformasi from "./CardPermohonanInformasi";
import CardDinamis from "./CardDinamis";
import CardStatistikPPID from "./CardStatistikPPID";
import CekStatusPermohonanInformasiPublik from "./CardCekPermohonanInformasiPublik";
import CardPengajuanKeberatan from "./CardPengajuanKeberatan";
import CardCekPengajuanKeberatan from "./CardCekPengajuanKeberatan";

const iconMap: any = {
  Inbox,
  FileText,
  Target,
  User,
  Megaphone,
  ClipboardList,
  Layers,
  BookOpen,
};

export default function DaftarInformasiPublik({
  menu_ppid,
  jumlahDokumen,
  jumlahPermohonanInformasi,
  jumlahUnduhan,
  jumlahLihat,
  jumlahBerkala,
  jumlahSertaMerta,
  jumlahSetiapSaat,
}: any) {
const menu_lain = [
  {
    id: "daftar-informasi",
    label: "Daftar Informasi Publik",
    icon: Inbox, // cocok untuk daftar/arsip
  },
  {
    id: "permohonan-informasi",
    label: "Permohonan Informasi",
    icon: FileText, // cocok karena terkait dokumen
  },
  {
    id: "cek-permohonan",
    label: "Cek Status Permohonan Informasi Publik",
    icon: Search, // lebih relevan untuk pencarian/cek status
  },
  {
    id: "pengajuan-keberatan",
    label: "Pengajuan Keberatan",
    icon: FileQuestion, // ikon pertanyaan/keberatan
  },
  {
    id: "cek-status-pengajuan-keberatan",
    label: "Cek Status Pengajuan Keberatan",
    icon: ClipboardCheck, // cek status/progress
  },
];

  const menu_ditampilkan = [
    ...menu_ppid.map((item: any) => ({
      ...item,
      id: item.id ?? item.label.replace(/\s+/g, "-").toLowerCase(),
    })),
    ...menu_lain,
  ];

  // ambil default dari query ?menu=
  const urlParams =
    typeof window !== "undefined"
      ? new URLSearchParams(window.location.search)
      : null;

  const initialMenu = urlParams?.get("menu");

  // jangan langsung set aktif, kecuali ada query string
  const [activeId, setActiveId] = useState<any>(initialMenu || 1);
  const [content, setContent] = useState("");

  useEffect(() => {
    if (!activeId) return;

    const activeItem = menu_ditampilkan.find((item) => item.id === activeId);
    if (activeItem && "id" in activeItem) {
      setContent(activeItem.konten ?? "Belum ada data.");
    }

    // update query string (tanpa reload, tanpa scroll ke atas)
    const url = new URL(window.location.href);
    url.searchParams.set("menu", activeId);
    window.history.replaceState({}, "", url.toString());
  }, [activeId, menu_ditampilkan]);

  return (
    <GuestLayout>
      <PageLayout title="PPID Kota Kendari">
        <div className="flex flex-col lg:flex-row gap-6 lg:container">
          {/* Sidebar */}
          <div className="h-fit w-full lg:w-80 bg-white rounded-2xl shadow-lg p-5 flex flex-col gap-1">
            {menu_ditampilkan.map((item, i) => {
              const Icon =
                typeof item.icon === "string" ? iconMap[item.icon] : item.icon;

              return (
                <button
                  key={i}
                  onClick={() => setActiveId(item.id)}
                  className={`text-left text-sm flex items-center gap-3 px-3 py-[10px] rounded-xl font-semibold transition ${
                    activeId === item.id
                      ? "bg-[#1B3C60] text-white shadow-md"
                      : "text-gray-600 font-medium hover:bg-gray-50"
                  }`}
                >
                  <div
                    className={`w-8 h-6 flex items-center justify-center rounded-lg ${
                      activeId === item.id
                        ? "bg-white/20"
                        : "bg-gray-100 text-gray-500"
                    }`}
                  >
                    {Icon && <Icon className="size-4" />}
                  </div>
                  {item.label}
                </button>
              );
            })}
          </div>

          {/* Konten */}
          <div className="flex-1">
            {!activeId && (
              <div className="text-gray-500 text-center py-20">
                Silakan pilih menu di samping
              </div>
            )}

            {activeId === "daftar-informasi" && <CardInformasiPublik />}
            {activeId === "permohonan-informasi" && <CardPermohonanInformasi />}
            {activeId === "cek-permohonan" && (
              <CekStatusPermohonanInformasiPublik />
            )}

            {activeId === "pengajuan-keberatan" && <CardPengajuanKeberatan />}
            {activeId === "cek-status-pengajuan-keberatan" && <CardCekPengajuanKeberatan />}

            {/* dinamis */}
            {menu_ppid.some((m: any) => m.id === activeId) && (
              <CardDinamis
                title={
                  menu_ditampilkan.find((m) => m.id === activeId)?.label ||
                  activeId
                }
                content={content}
                lampiran={menu_ditampilkan.find((m) => m.id === activeId)?.lampiran || null}
              />
            )}

            {/* statistik tetap ditampilkan di bawah */}
            <CardStatistikPPID
              jumlahDokumen={jumlahDokumen}
              jumlahPermohonanInformasi={jumlahPermohonanInformasi}
              jumlahUnduhan={jumlahUnduhan}
              jumlahLihat={jumlahLihat}
              jumlahBerkala={jumlahBerkala}
              jumlahSertaMerta={jumlahSertaMerta}
              jumlahSetiapSaat={jumlahSetiapSaat}
            />
          </div>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
