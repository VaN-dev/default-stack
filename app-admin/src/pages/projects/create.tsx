import { NextPage } from 'next';
import { AdminLayout } from '@layout';
import React from 'react';
import { Form, Button } from 'react-bootstrap';
import { useRouter } from 'next/router';
import useCreateProject, { CreateProjectPayload } from '../../hooks/api/project/useCreateProject';

const ProjectsCreate: NextPage = () => {
  const router = useRouter();
  const { createProject } = useCreateProject();
  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    const target = event.target as HTMLFormElement;

    const payload: CreateProjectPayload = {
      title: target.title.value,
    };

    const { data: error } = await createProject(payload);

    if (!error) {
      await router.push('/projects');
    }
  };

  return (
    <AdminLayout>
      <Form onSubmit={handleSubmit}>
        <Form.Group className="mb-3" controlId="formBasicTitle">
          <Form.Label>Title</Form.Label>
          <Form.Control type="text" name="title" placeholder="Enter title" />
        </Form.Group>

        <Button variant="primary" type="submit">
          Submit
        </Button>
      </Form>
    </AdminLayout>
  );
};
export default ProjectsCreate;
