import { useEffect } from 'react';
// import { usePrevious } from 'react-use';
import useSWR from 'swr';
import type { SWRResponse } from 'swr';
import fetcher from './fetcher';
// import UserContext from "../../contexts/UserContext";

// Hook for API calls using cache
function useSWRRequest<T>(endpoint: string | null): SWRResponse<T, unknown> {
  // const { setToken, token } = useContext(UserContext);

  const token = 'dummy-token for useSWRRequest';

  const response = useSWR<T>(
    endpoint && token ? [endpoint, token] : null,
    fetcher,
  );

  const { error: { code: errorCode } = { code: null } } = response;

  // const previousErrorCode = usePrevious(errorCode);

  useEffect(() => {
    // if (previousErrorCode !== errorCode && errorCode === 401) {
    if (errorCode === 401) {
      // setToken && setToken(null);
    }
  }, [
    errorCode,
    // previousErrorCode,
    // setToken,
    token,
  ]);

  return response;
}

export default useSWRRequest;
