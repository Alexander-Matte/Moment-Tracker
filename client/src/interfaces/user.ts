export interface User {
  "@id"?: string;
  email: string;
  plainPassword?: string;
  birthday?: Date;
  readonly created_at?: Date;
  readonly updated_at?: Date;
}
