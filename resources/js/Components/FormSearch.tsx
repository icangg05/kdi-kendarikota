import { useState } from "react";
import { PlaceholdersAndVanishInput } from "./ui/aceternity/vanish-input";

const FormSearch = () => {
  const [search, setSearch] = useState<string>("");

  const placeholders = [
    "Berita terbaru hari ini di kota kita",
    "Apa kebijakan terbaru dari pemerintah kota?",
    "Bagaimana perkembangan proyek infrastruktur terbaru?",
    "Informasi terbaru tentang program pemerintah Kota Kendari",
    "Jadwal kegiatan resmi Walikota Kendari",
    "Update terbaru tentang anggaran pembangunan Kota Kendari",
    "Informasi tentang layanan kesehatan terbaru di Kendari",
    "Berita tentang festival atau event budaya di Kendari",
    "Berita terbaru tentang penanganan banjir di Kendari",
    "Bagaimana perkembangan pembangunan jalan di Kota Kendari?",
    "Informasi tentang program bantuan sosial di Kendari",
    "Informasi tentang program pelestarian lingkungan di Kendari",
    "Update tentang pengembangan pariwisata di Kota Kendari",
  ];

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSearch(e.target.value);
  };
  const onSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setTimeout(() => {
      window.open("https://berita.kendarikota.go.id/?s=" + search, "_blank");
    }, 1000);
  };

  return (
    <div className="flex flex-col justify-center items-center px-4">
      <PlaceholdersAndVanishInput
        placeholders={placeholders}
        onChange={handleChange}
        onSubmit={onSubmit}
      />
    </div>
  );
};

export default FormSearch;
