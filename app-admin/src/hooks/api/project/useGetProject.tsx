import { Project } from '@models/project';
import useSWRRequest from '../useSWRRequest';

function useGetProject(id: string): {
  error: boolean;
  loading: boolean;
  project: Project | undefined;
} {
  const { data, error } = useSWRRequest<Project>(`/projects/${id}`);

  return {
    error: Boolean(error),
    loading: !error && !data,
    project: data,
  };
}

export default useGetProject;
