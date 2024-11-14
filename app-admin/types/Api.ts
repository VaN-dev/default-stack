type Errors = {
  field?: string;
  message?: string;
};

export type ErrorResponse = {
  code?: number;
  data?: {
    error?: {
      value?: number;
    };
    errors?: Errors[];
    message?: string;
  };
  detail?: { file: string; line: number; stackTrace: string };
};
