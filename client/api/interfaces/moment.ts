export interface Moment {
  "@id"?: string;
  user_id?: string;
  title?: string;
  description?: string;
  date_from?: Date;
  date_to?: Date;
  exact_date?: Date;
  region?: string;
  county_id?: string[];
  submoments?: string[];
  readonly created_at?: Date;
  readonly updated_at?: Date;
}
