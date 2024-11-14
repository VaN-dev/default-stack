import { Card } from 'react-bootstrap';
import React from 'react';
import useHealthcheck from '../../hooks/api/healthcheck/useHealthcheck';

export default function Healthcheck() {
  const { status, loading } = useHealthcheck();

  let bg = 'info';
  let label: string | undefined = 'unknown';
  if (!loading) {
    bg = status !== 200 ? 'danger' : 'success';
    label = status?.toString();
  }

  return (
    <Card bg={bg} text="white" className="">
      <Card.Body className="d-flex justify-content-between align-items-start">
        <div>
          <div className="fw-normal">
            API Status:
            <span className="fs-6 ms-2 fw-semibold">{ loading ? 'loading' : label }</span>
          </div>
        </div>
      </Card.Body>
    </Card>
  );
}
