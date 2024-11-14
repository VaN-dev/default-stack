import { Project } from '@models/project';
import useSWRRequest from '../useSWRRequest';

function useListProjects(): {
  error: boolean;
  loading: boolean;
  projects: Project[];
} {
  const { data, error } = useSWRRequest<Project[]>('/projects');

  return {
    error: Boolean(error),
    loading: !error && !data,
    projects: data ?? [],
  };
}

export default useListProjects;
