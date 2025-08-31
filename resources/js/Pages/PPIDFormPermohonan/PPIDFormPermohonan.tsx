import { Card } from "@/Components/card";
import GuestLayout from "@/Layouts/GuestLayout";
import PageLayout from "@/Layouts/PageLayout";
import FormInputPermohonan from "./FormInputPermohonan";

export default function FormPermohonan() {
  return (
    <GuestLayout>
      <PageLayout title="Form Permohonan Informasi Publik">
        <div className="mx-auto max-w-5xl">
          <Card className="p-6">
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
