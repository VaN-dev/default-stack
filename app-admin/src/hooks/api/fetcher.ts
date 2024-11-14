function getHeaders(token?: Token) {
  return {
    Accept: 'application/json',
    'Content-Type': 'application/json',
    ...(token && { Authorization: `Bearer ${token}` }),
  };
}

type Token = string | null | undefined;

const API_URL = process.env.NEXT_PUBLIC_API_BASE_URL;

export async function unauthentifiedFetcher<T>(
  resource: string,
  payload?: unknown,
  method = 'GET',
): Promise<T> {
  const headers = getHeaders();

  const response = await fetch(`${API_URL}${resource}`, {
    ...(payload ? { body: JSON.stringify(payload) } : null),
    headers,
    method,
  });

  if (response.status === 204) {
    return {} as T;
  }

  const data = await response.json();

  if (
    (data.code && data.code !== 200)
    || (response.status >= 400 && response.status <= 499)
  ) {
    return Promise.reject(new Error(data.toString()));
  }

  return data;
}

export function isTokenValid(token?: string | null): boolean {
  return !!token;
}

export default async function fetcher<T>(
  resource: string,
  token: Token,
  payload?: unknown,
  method = 'GET',
): Promise<T> {
  if (!isTokenValid(token)) {
    return Promise.reject(new Error('401'));
  }

  const headers = getHeaders(token);

  const response = await fetch(`${API_URL}${resource}`, {
    ...(payload ? { body: JSON.stringify(payload) } : null),
    headers,
    method,
  });

  if (response.status === 204) {
    return {} as T;
  }

  const data = await response.json();

  if (
    (data.code && data.code !== 200)
    || (response.status >= 400 && response.status <= 499)
  ) {
    return Promise.reject(new Error(data));
  }

  return data;
}
