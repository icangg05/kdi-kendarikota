import { Card } from "@/Components/card";
import GuestLayout from "@/Layouts/GuestLayout";
import PageLayout from "@/Layouts/PageLayout";
import FormInputPermohonan from "./FormInputPermohonan";
import { AlertCircle, ExternalLink } from "lucide-react";
import { Link } from "@inertiajs/react";

export default function FormPermohonan() {
  return (
    <GuestLayout>
      <PageLayout title="Form Permohonan Informasi Publik">
        <div className="mx-auto max-w-5xl">
          <Card className="p-6">
            {/* Alert Section */}
            <div className="mb-4 flex items-start gap-3 rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm lg:text-base text-blue-700">
              <AlertCircle className="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-600" />
              <div>
                <p>
                  Setelah permohonan diajukan, permohonan akan diverifikasi
                  dalam waktu <b>1x24 jam</b>. Proses pengerjaan atau penyediaan
                  informasi memerlukan waktu maksimal <b>1 minggu</b>. Anda dapat
                  memantau status permohonan secara berkala melalui{" "}
                  <Link
                    href="/ppid?menu=cek-permohonan"
                    className="inline-flex items-center gap-0.5 font-medium text-blue-600 hover:underline"
                  >
                    <ExternalLink className="h-4 w-4" />
                    Cek Permohonan
                  </Link>
                  .
                </p>
              </div>
            </div>

            <hr className="mt-6 mb-4" />

            <h1 className="text-lg font-bold mb-4">
              Form Permohonan Informasi Publik
            </h1>
            <p className="text-xs text-red-500 mb-6">* Wajib diisi</p>

            <FormInputPermohonan />
          </Card>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
