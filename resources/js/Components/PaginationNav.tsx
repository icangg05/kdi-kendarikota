import { router } from "@inertiajs/react";
import parse from "html-react-parser";
import {
  Pagination,
  PaginationContent,
  PaginationItem,
  PaginationLink,
  PaginationNext,
  PaginationPrevious,
} from "@/Components/ui/pagination";

const PaginationNav = ({ links }: any) => {
  const handlePageChange = (url: any) => {
    if (url != null) {
      router.get(url, { preserveState: true });
    }
  };

  return (
    <Pagination>
      <PaginationContent className="flex flex-wrap">
        {links.map((link: any, i: any) => (
          <PaginationItem key={i}>
            {link.label == "pagination.previous" ? (
              <PaginationPrevious
                className="cursor-pointer"
                onClick={(e) => {
                  e.preventDefault();
                  handlePageChange(link.url);
                }}
              />
            ) : link.label == "pagination.next" ? (
              <PaginationNext
                className="cursor-pointer"
                onClick={(e) => {
                  e.preventDefault();
                  handlePageChange(link.url);
                }}
              />
            ) : (
              <PaginationLink
                isActive={link.active}
                className="cursor-pointer"
                onClick={(e) => {
                  e.preventDefault();
                  handlePageChange(link.url);
                }}
              >
                {parse(link.label)}
              </PaginationLink>
            )}
          </PaginationItem>
        ))}
      </PaginationContent>
    </Pagination>
  );
};

export default PaginationNav;
