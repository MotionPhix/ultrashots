import type { CountryCode } from 'maz-ui/components/MazPhoneNumberInput';

interface Temporay {
  label?: string;
  value?: number;
  missing?: boolean;
}

export interface Links {
  url: string;
  label: string;
  active: boolean;
}

export interface User {
  id: number;
  first_name?: string;
  last_name?: string;
  full_name?: string;
  email?: string;
  email_verified_at?: string;
}

export interface Account {
  id?: number;
  aid?: string;
  name?: string;
  slogan?: string;
  url?: string;
  address?: string;
  user_id: number;
  logo?: string;
}

export interface Company {
  id?: string|number;
  name?: string;
  slogan?: string;
  url?: string;
  address?: Address;
}

export interface Phone {
  id?: number;
  formatted?: string;
  country_code?: CountryCode;
  is_primary_phone?: boolean;
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
  is_primary_email?: boolean;
  email?: string;
}

export interface Contact {
  id?: number;
  cid?: string;
  full_name?: string;
  first_name: string;
  last_name: string;
  middle_name?: string;
  job_title?: string;
  is_favorite?: boolean;
  bio?: string;
  emails?: Email[];
  phones?: Phone[];
  company_id?: number;
  deleted_at?: string;
  work?: Company;
  last_phone?: Phone;
  last_email?: Email;
  tags?: Tag[];
}

export interface ContactsBase {
  [group: string]: Contact[];
}

export interface Group {
  id?: number;
  gid?: string;
  name?: string;
  user_id?: number;
  color?: string;
  contacts_count?: number;
  contacts?: Contact[];
  description?: string;
}

export interface Tag {
  id?: number;
  name?: string;
  slug?: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user?: User;
    avatar?: string,
    role?: string
  };
};
