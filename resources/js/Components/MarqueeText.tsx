import { usePage } from "@inertiajs/react";

export default function MarqueeText() {
  const { pengaturan } = usePage().props as any;
  const teksBerjalan = pengaturan.find(
    (item: any) => item.slug == "teks_berjalan"
  )?.value;
  const teksBerjalanArr = teksBerjalan ? teksBerjalan.split("###") : [];

  return (
    <div className="bg-blue-100">
      <div className="max-w-7xl mx-auto overflow-hidden whitespace-nowrap mb-7 py-3">
        <div className="inline-block animate-marquee text-blue-900 font-semibold text-[15px] lg:text-lg">
          {teksBerjalanArr.length > 0 &&
            teksBerjalanArr.map((item: any, i: any) => (
              <span key={i}>{item}</span>
            ))}
        </div>
      </div>
    </div>
  );
}
