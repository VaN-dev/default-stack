import type { SWRResponse } from 'swr';
import useSWR from 'swr';

import { unauthentifiedFetcher } from './fetcher';

// Hook for unauthentified API calls using cache
function useSWRRequest<T>(endpoint: string | null): SWRResponse<T, unknown> {
  return useSWR<T>(endpoint ? [endpoint] : null, unauthentifiedFetcher);
}

export default useSWRRequest;
