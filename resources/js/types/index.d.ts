export interface Links {
  url: string;
  label: string;
  active: boolean;
}

type CountryCode = 'AC' | 'AD' | 'AE' | 'AF' | 'AG' | 'AI' | 'AL' | 'AM' | 'AO' | 'AR' | 'AS' | 'AT' | 'AU' | 'AW' | 'AX' | 'AZ' | 'BA' | 'BB' | 'BD' | 'BE' | 'BF' | 'BG' | 'BH' | 'BI' | 'BJ' | 'BL' | 'BM' | 'BN' | 'BO' | 'BQ' | 'BR' | 'BS' | 'BT' | 'BW' | 'BY' | 'BZ' | 'CA' | 'CC' | 'CD' | 'CF' | 'CG' | 'CH' | 'CI' | 'CK' | 'CL' | 'CM' | 'CN' | 'CO' | 'CR' | 'CU' | 'CV' | 'CW' | 'CX' | 'CY' | 'CZ' | 'DE' | 'DJ' | 'DK' | 'DM' | 'DO' | 'DZ' | 'EC' | 'EE' | 'EG' | 'EH' | 'ER' | 'ES' | 'ET' | 'FI' | 'FJ' | 'FK' | 'FM' | 'FO' | 'FR' | 'GA' | 'GB' | 'GD' | 'GE' | 'GF' | 'GG' | 'GH' | 'GI' | 'GL' | 'GM' | 'GN' | 'GP' | 'GQ' | 'GR' | 'GT' | 'GU' | 'GW' | 'GY' | 'HK' | 'HN' | 'HR' | 'HT' | 'HU' | 'ID' | 'IE' | 'IL' | 'IM' | 'IN' | 'IO' | 'IQ' | 'IR' | 'IS' | 'IT' | 'JE' | 'JM' | 'JO' | 'JP' | 'KE' | 'KG' | 'KH' | 'KI' | 'KM' | 'KN' | 'KP' | 'KR' | 'KW' | 'KY' | 'KZ' | 'LA' | 'LB' | 'LC' | 'LI' | 'LK' | 'LR' | 'LS' | 'LT' | 'LU' | 'LV' | 'LY' | 'MA' | 'MC' | 'MD' | 'ME' | 'MF' | 'MG' | 'MH' | 'MK' | 'ML' | 'MM' | 'MN' | 'MO' | 'MP' | 'MQ' | 'MR' | 'MS' | 'MT' | 'MU' | 'MV' | 'MW' | 'MX' | 'MY' | 'MZ' | 'NA' | 'NC' | 'NE' | 'NF' | 'NG' | 'NI' | 'NL' | 'NO' | 'NP' | 'NR' | 'NU' | 'NZ' | 'OM' | 'PA' | 'PE' | 'PF' | 'PG' | 'PH' | 'PK' | 'PL' | 'PM' | 'PR' | 'PS' | 'PT' | 'PW' | 'PY' | 'QA' | 'RE' | 'RO' | 'RS' | 'RU' | 'RW' | 'SA' | 'SB' | 'SC' | 'SD' | 'SE' | 'SG' | 'SH' | 'SI' | 'SJ' | 'SK' | 'SL' | 'SM' | 'SN' | 'SO' | 'SR' | 'SS' | 'ST' | 'SV' | 'SX' | 'SY' | 'SZ' | 'TA' | 'TC' | 'TD' | 'TG' | 'TH' | 'TJ' | 'TK' | 'TL' | 'TM' | 'TN' | 'TO' | 'TR' | 'TT' | 'TV' | 'TW' | 'TZ' | 'UA' | 'UG' | 'US' | 'UY' | 'UZ' | 'VA' | 'VC' | 'VE' | 'VG' | 'VI' | 'VN' | 'VU' | 'WF' | 'WS' | 'XK' | 'YE' | 'YT' | 'ZA' | 'ZM' | 'ZW';

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
}

export interface Project {
  id?: number;
  name?: string;
  description?: string;
  status?: string;
  company_id?: number|null;
  contact_id?: number|null;
  progress?: number;
  deadline?: date|string;
  contact?: Contact;
  tasks?: Task[];
  users?: User[];
  company?: Company;
  boards?: Board[]
}

export interface ContactApiResponse {
  data: Contact[];
  total?: number;
  links?: Links[];
  from?: number;
  to?: number;
}

export interface ProjectApiResponse {
  data: Project[];
  total?: number;
  links?: Links[];
  from?: number;
  to?: number;
}

export interface ContactsData {
  [group: string]: Contact[];
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: User;
    avatar: string,
    role: string
  };
};
