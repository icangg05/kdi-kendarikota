export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at?: string;
}

export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>
> = T & {
  auth: {
    user: User;
  };
};

export interface Post {
  id: number;
  title: { rendered: string };
  link: string;
  date: string;
  better_featured_image?: { source_url: string };
}

export interface ApiResponse {
  loading: boolean;
  response: Post[] | null;
  error: string | null;
}

type WordObject = {
  text: string;
  className?: string;
};
