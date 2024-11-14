import type { Dispatch, SetStateAction } from 'react';

export type Token = string | null | undefined;
export type SetToken = Dispatch<SetStateAction<Token>>;

export type UserContextType =
  | {
      setToken: SetToken;
      token: Token;
    }
  | Record<string, never>;
