import { WordObject } from "@/types";
import axios from "axios";
import { Download } from "lucide-react";

export function convertStringToWords(inputString: string): WordObject[] {
  return inputString.split(" ").map((word, index, array) => {
    const obj: WordObject = { text: word };
    if (index === array.length - 1) {
      obj.className = "text-blue-400";
    }
    return obj;
  });
}

export const navProgramKotaku = {
  title: "Program Kotaku",
  menu: [
    {
      label: "Tentang Kotaku",
      url: "https://kotaku.pu.go.id/page/6880/tentang-program-kota-tanpa-kumuh-kotaku",
    },
    {
      label: "Dokumen",
      subMenu: [
        {
          label: "SK Pengurangan Kumuh 2020",
          url: "/storage/dokumen/program-kotaku/SK-Kumuh-Walikota-Kendari-2020.pdf",
        },
        {
          label:
            "Lokasi & Besaran Bantuan Kegiatan Infrastruktur Berbasis Masyarakat",
          subMenu: [
            {
              label: "Tahun 2017",
              url: "/storage/dokumen/program-kotaku/1-surat-daftar-lokasi-dan-alokasi-bantuan-pemerintah-2017.pdf",
            },
            {
              label: "Tahun 2018",
              url: "/storage/dokumen/program-kotaku/180522-DAFLOK-BDI-2018.pdf",
            },
            {
              label: "Tahun 2019",
              url: "/storage/dokumen/program-kotaku/surat-dir-pkp-no-bw-0901-ttg-lokasi-alokasi-bpm-2019-nsup-kotaku.pdf",
            },
            {
              label: "Tahun 2020",
              url: "/storage/dokumen/program-kotaku/Kepmen-PUPR-167-Lokasi-IBM-TA-2020.pdf",
            },
            {
              label: "Tahun 2021",
              url: "/storage/dokumen/program-kotaku/20210222-Kepmen-PUPR-No-177-KPTS-M-2021-penetapan-lokasi-dan-besaran-bantuan-kegiatan-IBM-2021.pdf",
            },
          ],
        },
      ],
    },
    {
      label: "Profil Kumuh",
      subMenu: [
        {
          label: "Profil Kumuh 19 Parameter",
          url: "http://103.12.84.58/slum/profil/umum",
        },
        {
          label: "Profil Kumuh 16 Parameter",
          url: "http://103.12.84.58/slum/profil16p/umum",
        },
      ],
    },
    {
      label: "Realisasi Kegiatan Skala Kawasan",
      subMenu: [
        {
          label: "Informasi Umum",
          url: "http://103.12.84.58/report/skala_kawasan/informasi_umum_kawasan?prop=74",
        },
        {
          label: "Lelang Progres",
          url: "http://103.12.84.58/report/skala_kawasan/progres_lelang?prop=74",
        },
        {
          label: "Selesai Lelang",
          url: "http://103.12.84.58/report/skala_kawasan/selesai_lelang?prop=74",
        },
        {
          label: "Progres Pembayaran",
          url: "http://103.12.84.58/report/skala_kawasan/progres_pembayaran?prop=74",
        },
        {
          label: "Output Kegiatan",
          url: "http://103.12.84.58/report/skala_kawasan/output_kegiatan?kota=7471",
        },
      ],
    },
    {
      label: "Realisasi Kegiatan Kolaborasi",
      subMenu: [
        {
          label: "Tahun 2015",
          url: "http://103.12.84.58/report/kolaborasi_wb?th=2015&tha=2015&Kota=7471",
        },
        {
          label: "Tahun 2016",
          url: "http://103.12.84.58/report/kolaborasi_wb?th=2016&tha=2016&Kota=7471",
        },
        {
          label: "Tahun 2017",
          url: "http://103.12.84.58/report/kolaborasi_wb?th=2017&tha=2017&Kota=7471",
        },
        {
          label: "Tahun 2018",
          url: "http://103.12.84.58/report/kolaborasi_wb?th=2018&tha=2018&Kota=7471",
        },
        {
          label: "Tahun 2019",
          url: "http://103.12.84.58/report/kolaborasi_wb?th=2019&tha=2019&Kota=7471",
        },
        {
          label: "Tahun 2020",
          url: "http://103.12.84.58/report/kolaborasi_wb?th=2020&tha=2020&Kota=7471",
        },
        {
          label: "Tahun 2021",
          url: "http://103.12.84.58/report/kolaborasi_wb?th=2021&tha=2021&Kota=7471",
        },
      ],
    },
    {
      label: "Realisasi Kegiatan Skala Lingkungan",
      subMenu: [
        {
          label: "Tahun 2017",
          url: "http://103.12.84.58/report/pencairan?th=2017&blm=1&Kota=7471",
        },
        {
          label: "Tahun 2018",
          url: "http://103.12.84.58/report/pencairan?th=2018&blm=1&Kota=7471",
        },
        {
          label: "Tahun 2019",
          url: "http://103.12.84.58/report/pencairan?th=2019&blm=1&Kota=7471",
        },
        {
          label: "Tahun 2020",
          url: "http://103.12.84.58/report/pencairan?th=2020&blm=1&Kota=7471",
        },
        {
          label: "Tahun 2021",
          url: "http://103.12.84.58/report/pencairan?th=2021&blm=1&Kota=7471",
        },
      ],
    },
    {
      label: "Foto Kegiatan Skala Kawasan",
      subMenu: [
        {
          label: "Tahun 2019",
          url: "http://103.12.84.58/report/foto_realisasi_kegiatan_kawasan?th=2019&prop=74",
        },
        {
          label: "Tahun 2021",
          url: "http://103.12.84.58/report/foto_realisasi_kegiatan_kawasan?th=2021&prop=74",
        },
      ],
    },
    {
      label: "Foto Kegiatan Padat Karya",
      subMenu: [
        {
          label: "Tahun 2019",
          url: "http://103.12.84.58/report/realisasi_kegiatan?th=2019&prop=74",
        },
        {
          label: "Tahun 2020",
          url: "http://103.12.84.58/report/realisasi_kegiatan?th=2020&prop=74",
        },
        {
          label: "Tahun 2021",
          url: "http://103.12.84.58/report/realisasi_kegiatan?th=2021&prop=74",
        },
      ],
    },
  ],
};

export const menuProfil = {
  label: "Profil",
  menu: [
    {
      title: "Sejarah Kota Kendari",
      href: "/kendari-kita/sejarah-kota-kendari",
      description: "Ketahui sejarah dan asal-usul perkembangan Kota Kendari",
    },
    {
      title: "Visi & Misi",
      href: "/kendari-kita/visi-misi",
      description: "Tujuan dan arah pembangunan Kota Kendari",
    },
    {
      title: "Profil Walikota",
      href: "/kendari-kita/walikota",
      description: "Informasi tentang Walikota Kendari saat ini",
    },
    {
      title: "Profil Wakil Walikota",
      href: "/kendari-kita/wakil-walikota",
      description: "Informasi tentang Wakil Walikota Kendari saat ini",
    },
    {
      title: "Pejabat Pemerintah",
      href: "/kendari-kita/pejabat-pemerintah",
      description: "Daftar pejabat yang bertugas di pemerintahan kota",
    },
    {
      title: "Perangkat Daerah",
      href: "/kendari-kita/perangkat-daerah",
      description:
        "Struktur organisasi perangkat daerah pemerintah Kota Kendari",
    },
  ],
};

export const menuEvent = {
  label: "Event",
  menu: [
    {
      title: "Agenda",
      href: "/event/agenda",
      description: "Jadwal acara dan kegiatan resmi di Kendari",
    },
    {
      title: "Pengumuman",
      href: "/event/pengumuman",
      description: "Informasi penting dan pengumuman pemerintah Kota Kendari",
    },
  ],
};

export const menuArsip = {
  label: "Arsip",
  url: "/arsip",
  description: "Akses dokumen arsip Pemerintah Kota Kendari",
};

export const menuPeraturanDaerah = {
  label: "Peraturan Daerah",
  url: "/peraturan-daerah",
  description: "Peraturan daerah Pemerintah Kota Kendari",
};

export const menuStatistik = {
  label: "Statistik",
  url: "/statistik",
  description: "Statistik dan laporan Pemerintah Daerah Kota Kendari",
};

export const menuPPID = {
  label: "PPID",
  url: "/ppid",
  description: "Layanan informasi publik dan dokumentasi resmi Pemerintah Kota Kendari",
};

export const columnsPengumuman = [
  {
    accessorKey: "judul",
    header: "Judul",
    cell: ({ row }: any) => (
      <div className="capitalize w-[90%]">{row.getValue("judul")}</div>
    ),
  },
  {
    accessorKey: "sumber",
    header: "Sumber",
    cell: ({ row }: any) => (
      <div className="capitalize">{row.getValue("sumber")}</div>
    ),
  },
  {
    accessorKey: "tanggal",
    header: "Tanggal Upload",
    cell: ({ row }: any) => (
      <div className="capitalize">{row.getValue("tanggal")}</div>
    ),
  },
  {
    accessorKey: "link",
    header: "Lihat",
    cell: ({ row }: any) => (
      <a
        aria-label="link"
        target="_blank"
        href={row.getValue("link")}
        className={`flex items-center space-x-1 bg-[#173454] transition ease-out text-white px-4 py-1 rounded-md text-[10px] w-fit ${
          row.getValue("link")
            ? "hover:bg-opacity-90"
            : "cursor-default bg-opacity-70"
        }`}
      >
        <Download size={14} /> <span>Download</span>
      </a>
    ),
  },
];

export const columnsArsip = [
  {
    accessorKey: "judul",
    header: "Judul",
    cell: ({ row }: any) => (
      <div className="capitalize w-[90%]">{row.getValue("judul")}</div>
    ),
  },
  {
    accessorKey: "sumber",
    header: "Sumber",
    cell: ({ row }: any) => (
      <div className="capitalize">{row.getValue("sumber")}</div>
    ),
  },
  {
    accessorKey: "release",
    header: "Tanggal Upload",
    cell: ({ row }: any) => (
      <div className="capitalize text-nowrap">{row.getValue("release")}</div>
    ),
  },
  {
    accessorKey: "link",
    header: "Lihat",
    cell: ({ row }: any) => (
      <a
        aria-label="link"
        target="_blank"
        href={
          row.getValue("link") && row.getValue("link").startsWith("dokumen/")
            ? location.origin + `/storage/${row.getValue("link")}`
            : row.getValue("link") || "#"
        }
        className={`flex items-center space-x-1 bg-[#173454] transition ease-out text-white px-4 py-1 rounded-md text-[10px] w-fit ${
          row.getValue("link")
            ? "hover:bg-opacity-90"
            : "cursor-default bg-opacity-70"
        }`}
      >
        <Download size={14} /> <span>Download</span>
      </a>
    ),
  },
];

export const columnsStatistik = [
  {
    accessorKey: "judul",
    header: "Judul",
    cell: ({ row }: any) => (
      <div className="capitalize w-[90%]">{row.getValue("judul")}</div>
    ),
  },
  {
    accessorKey: "tanggal",
    header: "Tanggal",
    cell: ({ row }: any) => (
      <div className="capitalize">{row.getValue("tanggal")}</div>
    ),
  },
  {
    accessorKey: "download",
    header: "Download",
    cell: ({ row }: any) => (
      <div className="capitalize">
        {Number(row.getValue("download")).toLocaleString("id-ID")}
      </div>
    ),
  },
  {
    accessorKey: "link",
    header: "File",
    cell: ({ row }: any) => (
      <a
        aria-label="link"
        target="_blank"
        href={row.getValue("link")}
        className={`flex items-center space-x-1 bg-[#173454] transition ease-out text-white px-4 py-1 rounded-md text-[10px] w-fit ${
          row.getValue("link")
            ? "hover:bg-opacity-90"
            : "cursor-default bg-opacity-70"
        }`}
        onClick={async (e) => {
          if (!row.getValue("link")) {
            e.preventDefault();
          }
          const res = await axios.post("/api/count-download", {
            link: row.getValue("link"),
          });
          // console.log(res.data);
        }}
      >
        <Download size={14} /> <span>Download</span>
      </a>
    ),
  },
];

export const columnsPerda = [
  {
    accessorKey: "no_perda",
    header: "Nomor",
    cell: ({ row }: any) => (
      <div className="capitalize w-[170px]">{row.getValue("no_perda")}</div>
    ),
  },
  {
    accessorKey: "tentang",
    header: "Tentang",
    cell: ({ row }: any) => (
      <div className="capitalize w-[500px]">{row.getValue("tentang")}</div>
    ),
  },
  {
    accessorKey: "tanggal",
    header: "Tanggal Upload",
    cell: ({ row }: any) => (
      <div className="capitalize text-nowrap">{row.getValue("tanggal")}</div>
    ),
  },
  {
    accessorKey: "link",
    header: "File",
    cell: ({ row }: any) => (
      <a
        aria-label="link"
        target="_blank"
        href={row.getValue("link")}
        className={`flex items-center space-x-1 bg-[#173454] transition ease-out text-white px-4 py-1 rounded-md text-[10px] w-fit ${
          row.getValue("link")
            ? "hover:bg-opacity-90"
            : "cursor-default bg-opacity-70"
        }`}
      >
        <Download size={14} /> <span>Download</span>
      </a>
    ),
  },
];
