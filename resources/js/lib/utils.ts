import { clsx, type ClassValue } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export const formatTanggalIndo = (date: Date | string) => {
  const d = new Date(date);
  return d.toLocaleDateString("id-ID", {
    day: "numeric",
    month: "long",
    year: "numeric",
  });
};

export function titleCase(string: any) {
  return string
    .replace(/-/g, " ") // ganti semua "-" jadi spasi
    .toLowerCase()      // biar konsisten dulu
    .replace(/\b\w/g, (char: any) => char.toUpperCase()); // kapital tiap kata
}


export function getFileName(path: string): string {
  if (!path) return "";

  // Ambil nama file
  const fileNameWithExt = path.split("/").pop() || "";

  // Hilangkan ekstensi
  let fileName = fileNameWithExt.replace(/\.[^/.]+$/, "");

  // Hapus pola underscore + angka panjang di akhir (misalnya _20250829_133216)
  fileName = fileName.replace(/_\d{8}_\d{6}$/, "");

  // Opsional: ganti underscore jadi spasi
  return fileName.replace(/_/g, " ");
}
