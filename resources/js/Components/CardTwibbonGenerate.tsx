import { Card } from "./card";
import Form from "@/Components/twibbon/Form";
import { useEffect, useState } from "react";

const CardTwibbonGenerate = ({ twibbon }: any) => {
  const [frameTwibbon, setFrameTwibbon] = useState<string | null>(null);

  const handleLoadImage = async () => {
    try {
      const imageUrl = `/storage/${twibbon.img}`;
      const response = await fetch(imageUrl);
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      const blob = await response.blob();
      const reader = new FileReader();

      reader.onloadend = () => {
        const result = reader.result as string;
        setFrameTwibbon(result);
      };

      reader.readAsDataURL(blob);
    } catch (error) {
      console.error("Error loading image:", error);
    }
  };

  useEffect(() => {
    handleLoadImage();
  }, []);

  return (
    <Card className="p-3 py-5 lg:p-5 lg:py-7">
      <p className="mb-4 w-full lg:w-[90%] mx-auto font-extrabold font-sen text-base text-[#1A3C61] uppercase leading-tight text-center">
        {twibbon.title}
      </p>
      <Form title={twibbon.title} frameTwibbon={frameTwibbon} />
    </Card>
  );
};

export default CardTwibbonGenerate;
