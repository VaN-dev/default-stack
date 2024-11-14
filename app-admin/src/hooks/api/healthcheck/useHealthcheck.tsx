import useSWRRequest from '../useSWRRequest';

type Healthcheck = {
  status: number;
};
function useHealthcheck(): {
  error: boolean;
  loading: boolean;
  status?: number;
} {
  const { data, error } = useSWRRequest<Healthcheck>('/healthcheck');

  return {
    error: Boolean(error),
    loading: !error && !data,
    status: data?.status,
  };
}

export default useHealthcheck;
