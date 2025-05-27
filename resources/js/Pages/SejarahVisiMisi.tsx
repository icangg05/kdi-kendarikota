import GuestLayout from "@/Layouts/GuestLayout";
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/Components/card";
import parse from "html-react-parser";
import PageLayout from "@/Layouts/PageLayout";
import { ArrowBigUp } from "lucide-react";

export default function SejarahVisiMisi({
  title,
  data,
}: {
  title: string;
  data: any;
}) {
  return (
    <GuestLayout>
      <PageLayout title={title}>
        <div className="mx-auto max-w-3xl">
          <Card className="p-0 lg:px-3 lg:py-2 shadow-2xl shadow-blue-500/20">
            <CardHeader>
              <CardTitle className="text-base lg:text-lg font-bold">
                {title}
              </CardTitle>
            </CardHeader>
            <CardContent className="prose prose-sm prose-zinc">
              {parse(data.isi)}
            </CardContent>
            <CardFooter className="flex flex-col lg:flex-row space-y-3 lg:space-y-0 justify-between">
              <a
                aria-label="link"
                href="#"
                className="flex items-center space-x-1 text-sm hover:underline font-medium"
              >
                <ArrowBigUp className="w-[18px]" />
                <span> Kembali ke atas</span>
              </a>
            </CardFooter>
          </Card>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
