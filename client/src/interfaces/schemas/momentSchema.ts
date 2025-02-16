import { z } from 'zod';

export const momentSchema = z.object({
  title: z.string().min(3, "Title must be at least 3 characters"),
  description: z.string().optional(),
  date_from: z.coerce.date().optional(),
  date_to: z.coerce.date().optional(),
  exact_date: z.coerce.date().optional(),
  region: z.string().optional(),
  country_id: z.array(z.string()).optional(),
  submoments: z.array(z.string()).optional(),
});
