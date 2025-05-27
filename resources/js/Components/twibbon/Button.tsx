import { cva } from "class-variance-authority";

import { cn } from "@/lib/utils";
import { Link } from "@inertiajs/react";

const buttonVariants = cva(
  "inline-block rounded-full transition-all duration-500",
  {
    variants: {
      variant: {
        primary:
          "bg-primary-400 px-4 py-2 md:px-6 md:py-3 hover:bg-primary-200 text-base text-white disabled:text-neutral-500 disabled:bg-neutral-300",
        secondary:
          "border-primary-400 px-4 py-2 md:px-6 md:py-3 hover:bg-primary-50 text-base text-primary-400 disabled:bg-neutral-300 text-primary-400 disabled:text-neutral-500",
        tertiary:
          "text-base text-black hover:text-primary-400 text-black disabled:text-neutral-500",
        quartiary:
          "text-base px-4 py-2 md:px-6 md:py-3 text-primary-400 bg-white hover:bg-primary-50 disabled:bg-neutral-400 disabled:text-white",
      },
    },
  }
);

export function LinkButton({
  children,
  href,
  variant,
  className,
  target,
  scroll,
}: any) {
  return (
    <Link
      href={href}
      className={cn(buttonVariants({ variant }), className)}
      target={target}
      // scroll={scroll}
    >
      {children}
    </Link>
  );
}

export function Button({
  children,
  type,
  onClick,
  isDisabled,
  className,
  variant,
  ...props
}: any) {
  return (
    <button
      type={type}
      onClick={onClick}
      disabled={isDisabled}
      className={cn(buttonVariants({ variant }), className)}
      {...props}
    >
      {children}
    </button>
  );
}
