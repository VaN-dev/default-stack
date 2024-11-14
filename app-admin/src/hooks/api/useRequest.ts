import fetcher from './fetcher';

export type Endpoint = string;
export type Payload = unknown;
export type Method = string;

// Hook for API call without cache
function useRequest<Data, Error = unknown>(): (
  endpoint: Endpoint,
  payload?: Payload,
  method?: Method
) => Promise<{ data?: Data; error?: Error }> {
  async function request(
    endpoint: Endpoint,
    payload?: Payload,
    method: Method = 'POST',
  ) {
    try {
      const token = 'dummy-token for request';
      const data = await fetcher<Data>(endpoint, token, payload, method);

      return { data };
    } catch (error) {
      return { error: error as Error };
    }
  }

  return request;
}

export default useRequest;
