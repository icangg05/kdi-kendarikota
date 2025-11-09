import { Card } from "@/Components/card";

type InfoCardProps = {
  icon: React.ReactNode;
  title: string;
  bgColor: string;
  textColor: string;
  classes?: string;
  onClick?: () => void;
};

export default function CardJenisInformasi({ icon, title, classes = '', bgColor, textColor, onClick }: InfoCardProps) {
  return (
    <Card
      onClick={onClick}
      className="flex flex-col items-center justify-center gap-3 p-8 rounded-2xl shadow-md cursor-pointer transition-all duration-300 hover:shadow-xl hover:scale-105"
    >
      {/* Icon */}
      <div
        className={`w-16 h-16 flex items-center justify-center rounded-full ${bgColor} ${textColor}`}
      >
        {icon}
      </div>
      {/* Title */}
      <h3 className={`${classes ? classes : ''} text-center text-base font-semibold text-gray-700`}>
        {title}
      </h3>
    </Card>
  );
}
