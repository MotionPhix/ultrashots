import type { CountryCode } from 'maz-ui/components/MazPhoneNumberInput';

export interface Links {
  url: string;
  label: string;
  active: boolean;
}

export interface User {
  id: number;
  first_name?: string;
  last_name?: string;
  fullname?: string;
  email?: string;
}

export interface Company {
  id: number;
  name?: string;
  slogan?: string;
  url?: string;
  job_title?: string;
  department?: string;
  address?: string;
  pivot: {
    contact_id: number;
    company_id: number;
    job_title: string;
    department: string | null;
  };
}

export interface Interaction {
  id?: number;
  type: string;
  topic?: string;
  contact_id?: number;
  user_id?: number;
  interacted_on?: Date|string;
  interaction_date?: Date|string;
}

export interface Phone {
  id?: number;
  formatted?: string;
  country_code?: CountryCode;
  number?: string;
  type?: string;
}

export interface Address {
  id?: number;
  city?: string;
  state?: string;
  country?: string;
  street?: string;
  type?: string;
}

export interface Email {
  id?: number;
  email?: string;
}

export interface Contact {
  id?: number;
  cid?: string;
  title?: string;
  full_name?: string;
  first_name: string;
  last_name: string;
  middle_name?: string;
  nickname?: string;
  job_title?: string;
  is_favorite?: boolean;
  bio?: string;
  emails?: Email[];
  addresses?: Address[];
  phones?: Phone[];
  user_id?: number;
  deleted_at?: string;
  last_company?: Company;
  company?: Company;
  last_email?: Email;
  interactions?: Interaction[];
  tags: Tag[];
}

export interface Tag {
  id?: number;
  name: string;
  slug?: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: User;
    avatar: string,
    role: string
  };
};
