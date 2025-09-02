import { Link, usePage } from "@inertiajs/react";
import { Facebook, Instagram, Mail, Phone, Youtube } from "lucide-react";

const Footer = () => {
  const { pengaturan, admin } = usePage().props as any;

  const icons = [
    {
      link: pengaturan.find((item: any) => item.slug == "fb")?.value ?? '#',
      icon: <Facebook className="w-[20px]" />,
    },
    {
      link: pengaturan.find((item: any) => item.slug == "ig")?.value ?? '#',
      icon: <Instagram className="w-[20px]" />,
    },
    {
      link: pengaturan.find((item: any) => item.slug == "yt")?.value ?? '#',
      icon: <Youtube className="w-[20px]" />,
    },
  ];

  return (
    <>
      <footer className="py-8 bg-main text-white">
        <div className="container">
          <div className="grid grid-cols-4 gap-8 lg:gap-10">
            <div className="col-span-4 lg:col-span-1">
              <img src="/img/logo.svg" alt="logo" className="w-44 lg:w-52" />
              <p className="mt-6 mb-5 lg:mt-8 lg:mb-9  text-xs lg:text-sm">
                {pengaturan.find((item: any) => item.slug == "alamat").value ?? '-'}
              </p>
              <div className="flex items-center space-x-3.5 text-base lg:text-xl">
                {icons.map((item: any, i: any) => (
                  <a target="_blank" key={i} href={item.link} aria-label="link">
                    {item.icon}
                  </a>
                ))}
              </div>
            </div>

            <div className="col-span-4 lg:col-span-1">
              <p className="font-sen font-bold text-base lg:text-xl">
                Tautan Cepat
              </p>
              <div className="w-full h-1 relative mt-2">
                <div
                  className="absolute left-0 top-0 h-[1px] bg-[#2A619D]"
                  style={{ width: "10%" }}
                ></div>
                <div
                  className="absolute right-0 top-0 h-[1px] bg-[#E4E4E7]"
                  style={{ width: "90%" }}
                ></div>
              </div>

              <div className="mt-4 flex flex-wrap flex-row lg:flex-col gap-5 gap-y-1.5 lg:gap-3.5 text-xs lg:text-sm">
                <Link href="/">Beranda</Link>
                <Link href="/kendari-kita/sejarah-kota-kendari">Sejarah</Link>
                <Link href="/kendari-kita/visi-misi">Visi & Misi</Link>
                <Link href="/event/agenda">Agenda</Link>
                <Link href="/event/pengumuman">Pengumuman</Link>
                <Link href="/statistik">Statistik</Link>
              </div>
            </div>

            <div className="col-span-4 lg:col-span-1">
              <p className="font-sen font-bold text-base lg:text-xl">
                Eksternal Link
              </p>
              <div className="w-full h-1 relative mt-2">
                <div
                  className="absolute left-0 top-0 h-[1px] bg-[#2A619D]"
                  style={{ width: "10%" }}
                ></div>
                <div
                  className="absolute right-0 top-0 h-[1px] bg-[#E4E4E7]"
                  style={{ width: "90%" }}
                ></div>
              </div>

              <div className="mt-4 flex flex-wrap flex-row lg:flex-col gap-5 gap-y-1.5 lg:gap-3.5 text-xs lg:text-sm">
                <a
                  aria-label="link"
                  target="_blank"
                  href="https://indonesia.go.id"
                >
                  Indonesia
                </a>
                <a
                  aria-label="link"
                  target="_blank"
                  href="https://www.komdigi.go.id"
                >
                  Komdigi RI
                </a>
                <a
                  aria-label="link"
                  target="_blank"
                  href="https://www.kemendag.go.id"
                >
                  Kemendagri
                </a>
                <a
                  aria-label="link"
                  target="_blank"
                  href="https://www.sultraprov.go.id"
                >
                  Provinsi Sultra
                </a>
                <a
                  aria-label="link"
                  target="_blank"
                  href="https://www.lapor.go.id"
                >
                  Lapor
                </a>
              </div>
            </div>

            <div className="col-span-4 lg:col-span-1">
              <p className="font-sen font-bold text-base lg:text-xl">Kontak</p>
              <div className="w-full h-1 relative mt-2">
                <div
                  className="absolute left-0 top-0 h-[1px] bg-[#2A619D]"
                  style={{ width: "10%" }}
                ></div>
                <div
                  className="absolute right-0 top-0 h-[1px] bg-[#E4E4E7]"
                  style={{ width: "90%" }}
                ></div>
              </div>

              <div className="mt-4 flex flex-col space-y-1 text-xs lg:text-sm">
                <div className="flex items-center gap-x-2 text-white/80">
                  <Phone className="w-[13px] lg:w-[15px]" />
                  <span className="text-white">
                    {pengaturan.find((item: any) => item.slug == "no_hp_dinas").value ?? '-'}
                  </span>
                </div>
                <div className="flex items-center gap-x-2 text-white/80">
                  <Mail className="w-[13px] lg:w-[15px]" />
                  <span className="text-white">{admin?.email ?? "-"}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <section className="bg-[#1A3C61]">
        <div className="container py-4 lg:py-7 text-xs lg:text-sm text-white text-center">
          Copyright &copy; {2025}{" "}
          <a aria-label="link" href="/" className="hover:underline">
            Diskominfo
          </a>{" "}
          Kota Kendari. All Rights Reserved
        </div>
      </section>
    </>
  );
};

export default Footer;
